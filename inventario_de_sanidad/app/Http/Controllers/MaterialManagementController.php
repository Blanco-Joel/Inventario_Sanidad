<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as StorageFacade;

class MaterialManagementController extends Controller
{
    /**
     * Muestra la vista principal de materiales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('materials.index');
    }

    /**
     * Muestra la vista para crear (dar de alta) nuevos materiales.
     *
     * @return \Illuminate\View\View
     */
    public function createForm()
    {
        return view('materials.create');
    }

    /**
     * Devuelve en JSON la lista de todos los materiales ordenados por ID.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function materialsData()
    {
        return response()->json(Material::orderBy('material_id')->get());
    }

    /**
     * Muestra la vista para editar un material específico.
     *
     * @param Material $material
     * @return \Illuminate\View\View
     */
    public function edit(Material $material)
    {
        return view('materials.edit')->with('material', $material);
    }

    /**
     * Da de alta (guarda) en batch los materiales almacenados temporalmente en la cookie 'materialsAddBasket'.
     * Realiza toda la operación en una transacción, si hay error no se inserta nada.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBatch(Request $request)
    {
        // Valida que la cookie 'materialsAddBasket' esté presente en el request.
        $validated = $request->validate([
            'materialsAddBasket' => 'required'
        ], [
            'materialsAddBasket.required' => 'Debe introducir datos a la cesta'
        ]);

        // Decodifica la cookie desde JSON a un array asociativo. Si no es válido, usa array vacío.
        $basket = json_decode($validated['materialsAddBasket'], true) ?? [];

        // Si no hay datos válidos en la cesta, redirige con mensaje de error.
        if (empty($basket) || !is_array($basket)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de alta.');
        }

        // Array para almacenar información de imágenes que deben moverse tras la transacción.
        $imagesMaterials = [];

        try {
            // Inicia una transacción de base de datos: si algo falla, se revierte todo.
            DB::transaction(function () use ($basket, &$imagesMaterials) {
                // Itera sobre cada material en la cesta.
                foreach ($basket as $materialData) {
                    // Crea una nueva instancia del Material.
                    $material = new Material();
                    $material->name = $materialData["name"];
                    $material->description = $materialData["description"];
                    $material->image_path = null; // Se definirá después si hay imagen.
                    $material->save(); // Guarda el material en la base de datos.

                    // Si hay imagen temporal, guarda info para moverla después de la transacción.
                    if (!empty($materialData["image_temp"])) {
                        $imageName = pathinfo($materialData["image_temp"], PATHINFO_BASENAME);
                        $imagesMaterials[] = [
                            'material_id'   =>  $material->material_id,
                            'image_temp'    =>  $materialData["image_temp"],
                            'image_path'    =>  "materials/{$imageName}",
                        ];
                    }

                    // Registra el almacenamiento del material (en uso o reserva).
                    $this->storeMaterialInStorage($material, $materialData);
                }
            });

            // Si la transacción fue exitosa, elimina la cookie con los materiales temporales.
            Cookie::queue(Cookie::forget('materialsAddBasket'));

        } catch (\Exception $e) {
            // Si hay error en la transacción, muestra mensaje de error.
            return back()->with('error', 'Error al insertar los materiales: ' . $e->getMessage());
        }

        $failedMaterials = [];

        // Intenta mover cada imagen temporal a su ubicación definitiva.
        foreach ($imagesMaterials as $imageData) {
            try {
                $moved = StorageFacade::disk('public')->move($imageData["image_temp"], $imageData["image_path"]);

                if (!$moved) {
                    // Si no se pudo mover, se agrega el ID del material a la lista de fallidos.
                    $failedMaterials[] = $imageData["material_id"];
                } else {
                    // Si se movió correctamente, se actualiza el path de la imagen en la BD.
                    Material::where('material_id', $imageData["material_id"])->update(['image_path' =>  $imageData["image_path"]]);
                }
            } catch (\Exception $e) {
                // En caso de excepción, intenta recuperar el nombre del material y lo agrega a la lista de fallidos.
                $materialName = Material::where('material_id', $imageData["material_id"])->get('name');
                $failedMaterials[] = $materialName;
            }
        }

        // Limpia el directorio temporal de imágenes.
        StorageFacade::disk('public')->deleteDirectory('temp');

        // Si no hubo errores al mover imágenes, muestra mensaje de éxito.
        if (empty($failedMaterials)) {
            return back()->with('success', 'Materiales incorporados correctamente.');
        } else {
            // Si hubo fallos al mover imágenes, muestra advertencia con los materiales afectados.
            $failedList = implode(', ', $failedMaterials);
            return back()->with('warning', "Error al mover imágenes para los siguientes materiales: $failedList. Los demás se incorporaron correctamente.");
        }
    }

    /**
     * Registra el almacenamiento en los almacenes 'CAE' u 'odontology' para un material en los tipos 'use' y 'reserve'.
     *
     * @param Material $material           Instancia del material recién creado o existente.
     * @param array $materialData          Datos de entrada con la información de almacenamiento, incluyendo ubicación y unidades.
     */
    private function storeMaterialInStorage(Material $material, array $materialData)
    {
        // Determina en qué almacenes (CAE, odontology o ambos) se debe registrar el material.
        switch ($materialData['storage']) {
            case 'CAE':
                $storages = ['CAE']; // Solo en CAE.
                break;
            case 'odontology':
                $storages = ['odontology']; // Solo en odontología.
                break;
            case 'ambos':
            default:
                $storages = ['CAE', 'odontology']; // En ambos almacenes.
                break;
        }

        // Recorre cada almacén seleccionado...
        foreach ($storages as $storage) {
            // ...y para cada tipo de almacenamiento (uso y reserva).
            foreach (['use', 'reserve'] as $type) {
                // Crea un nuevo registro en la tabla de almacenamiento con la información correspondiente.
                Storage::create([
                    'material_id'  => $material->material_id,
                    'storage'      => $storage,
                    'storage_type' => $type,
                    'cabinet'      => $materialData[$type]['cabinet'],
                    'shelf'        => $materialData[$type]['shelf'],
                    'drawer'       => $materialData[$type]['drawer'],
                    'units'        => $materialData[$type]['units'],
                    'min_units'    => $materialData[$type]['min_units'],
                ]);
            }
        }
    }

    /**
     * Elimina un material.
     *
     * @param \App\Models\Material $material   Instancia del Material.
     * @return \Illuminate\Http\RedirectResponse   Redirección con mensaje de estado (éxito, advertencia o error).
     */
    public function destroy(Material $material)
    {
        try {
            // Verifica si el material aún existe en la base de datos mediante su ID.
            if (!Material::find($material->material_id)) {
                // Si no existe (puede haber sido eliminado previamente), muestra advertencia.
                return back()->with('warning', 'El material no existe o ya ha sido eliminado.');
            }

            // Almacena la ruta de la imagen asociada al material (si existe).
            $path = $material->image_path;

            // Si existe una imagen asociada al material, se elimina del disco público.
            if (!empty($path)) {
                StorageFacade::disk('public')->delete($path);
            }

            // Elimina el registro del material de la base de datos.
            $material->delete();

            // Devuelve una respuesta de éxito al usuario.
            return back()->with('success', 'Material eliminado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error durante el proceso, muestra un mensaje de error.
            return back()->with('error', 'Error al eliminar el material: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un material, incluida su imagen (opcional).
     *
     * @param Material $material    Instancia del Material a actualizar.
     * @param Request $request      Petición HTTP con los datos a validar y actualizar.
     * @return \Illuminate\Http\RedirectResponse   Redirección con mensaje de éxito o error.
     */
    public function update(Material $material, Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:60',
            'description' => 'required|string|max:100',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ], [
            'name.required'        => 'Debe introducir el nombre del material.',
            'description.required' => 'Debe introducir la descripción del material.',
            'image.image'          => 'El fichero debe ser una imagen.',
            'image.mimes'          => 'Solo se aceptan jpeg, png, jpg, gif o svg.',
            'image.max'            => 'La imagen no puede superar 4 MB.',
        ]);

        // Se guarda la ruta antigua de la imagen.
        $oldPath = $material->image_path;
        $newPath = null;

        // Si se ha subido una nueva imagen, se guarda en el disco 'public' en la carpeta 'materials'.
        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('materials','public');
        }

        try {
            // Inicia una transacción para asegurar que todos los cambios se realizan correctamente.
            DB::transaction(function() use ($material, $validated, $newPath, $oldPath) {
                $material->update([
                    'name'         => $validated['name'],
                    'description'  => $validated['description'],
                    'image_path'   => $newPath ?? $oldPath, // Si hay nueva imagen, se actualiza; si no, se mantiene la anterior.
                ]);

                // Si se subió una nueva imagen y existía una antigua, se elimina la anterior del disco.
                if ($newPath && $oldPath) {
                    $deleted = StorageFacade::disk('public')->delete($oldPath);

                    if (!$deleted) {
                        // Si no se pudo eliminar, se lanza una excepción para forzar el rollback.
                        throw new \Exception("No se pudo eliminar la imagen anterior");
                    }
                }
            });

            // Si todo fue bien, se muestra mensaje de éxito.
            return back()->with('success', 'Material editado correctamente.');
        } catch (\Exception $e) {
            // Si hubo un error, y se subió una nueva imagen, se elimina para evitar archivos huérfanos.
            if (!empty($newPath) && StorageFacade::disk('public')->exists($newPath)) {
                StorageFacade::disk('public')->delete($newPath);
            }

            // Se informa del error al usuario.
            return back()->with('error', 'Error al editar el material: ' . $e->getMessage());
        }
    }

    /**
     * Sube una imagen temporal y devuelve su ruta para uso posterior.
     *
     * @param Request $request  Petición HTTP que contiene la imagen enviada desde un formulario o cliente.
     * @return \Illuminate\Http\JsonResponse  Respuesta en formato JSON con la ruta temporal de la imagen.
     */
    public function uploadTemp(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);

        // Se almacena la imagen en la carpeta 'temp' del disco 'public' y devuelve la ruta relativa dentro del disco.
        $tempPath = $request->file('image')->store('temp', 'public');

        // Se retorna la ruta de la imagen temporal en una respuesta JSON
        // Si por alguna razón no se generó la ruta, se devuelve 'null'.
        return response()->json([
            'tempPath' => $tempPath ?? null
        ]);
    }
}
