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
        $validated = $request->validate([
            'materialsAddBasket' => 'required'
        ], [
            'materialsAddBasket.required' => 'Debe introducir datos a la cesta'
        ]);

        $basket = json_decode($validated['materialsAddBasket'], true) ?? [];
        if (empty($basket) || !is_array($basket)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de alta.');
        }

        $imagesMaterials = [];
    
        try {
            DB::transaction(function () use ($basket, &$imagesMaterials) {
                foreach ($basket as $materialData) {
                    // Crear material
                    $material = new Material();
                    $material->name = $materialData["name"];
                    $material->description = $materialData["description"];
                    $material->image_path = null;
                    $material->save();

                    // Preparar movimientos de imagen
                    if (!empty($materialData["image_temp"])) {
                        $imageName = pathinfo($materialData["image_temp"], PATHINFO_BASENAME);
                        $imagesMaterials[] = [
                            'material_id'   =>  $material->material_id,
                            'image_temp'    =>  $materialData["image_temp"],
                            'image_path'    =>  "materials/{$imageName}",
                        ];
                    }
                    
                    // Registrar almacenamiento de material en 'use' y 'reserve'
                    $this->storeMaterialInStorage($material, $materialData);
                }
            });

            // Mover imágenes al destino final y actualizar ruta en BD
            foreach ($imagesMaterials as $imageData) {
                StorageFacade::disk('public')->move($imageData["image_temp"], $imageData["image_path"]);
                Material::where('material_id', $imageData["material_id"])->update(['image_path' =>  $imageData["image_path"]]);
            }

            // Borrar carpeta temporal
            StorageFacade::disk('public')->deleteDirectory('temp');

            // Borrar cookie de cesta
            Cookie::queue(Cookie::forget('materialsAddBasket'));
    
            return back()->with('success', 'Materiales incorporados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al insertar los materiales: ' . $e->getMessage());
        }
    }    

    /**
     * Registra el almacenamiento para un material en los tipos 'use' y 'reserve'.
     *
     * @param Material $material
     * @param mixed $materialData Datos con info de almacenamiento
     */
    private function storeMaterialInStorage(Material $material, $materialData)
    {
        foreach (['use', 'reserve'] as $type) {
            Storage::create([
                'material_id'   => $material->material_id,
                'storage'       => $materialData['storage'],
                'storage_type'  => $type,
                'cabinet'       => $materialData[$type]['cabinet'],
                'shelf'         => $materialData[$type]['shelf'],
                'drawer'        => $materialData[$type]['drawer'],
                'units'         => $materialData[$type]['units'],
                'min_units'     => $materialData[$type]['min_units']
            ]);
        }
    }

    /**
     * Añade un material a la cesta para dar de baja (eliminar), guardando su ID en cookie.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToDeletionBasket(Request $request)
    {
        $validated = $request->validate([
            'material' => 'required|exists:materials,material_id'
        ], [
            'material.required' => 'Debe seleccionar un material.',
            'material.exists'   => 'El material seleccionado no existe.'
        ]);

        // Obtener cesta actual de eliminación o inicializar vacía
        $basket = Cookie::get('materialsRemovalBasket', '[]');
        $basket = json_decode($basket, true);
        if (!is_array($basket)) {
            $basket = [];
        }

        $material = Material::findOrFail($validated['material']);

        // Añadir material a la cesta
        $basket[] = [
            'material_id' => $material->material_id,
            'name'        => $material->name
        ];
        
        // Actualizar cookie (duración 1440 minutos = 1 día)
        Cookie::queue('materialsRemovalBasket', json_encode($basket), 1440);
        
        return back()->with('success', 'Material agregado a la cesta.');
    }

    /**
     * Elimina un material de la base de datos.
     *
     * @param Material $material
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Material $material)
    {
        try {
            if (!Material::find($material->material_id)) {
                return back()->with('warning', 'El material no existe o ya ha sido eliminado.');
            }

            $material->delete();

            return back()->with('success', 'Material eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el material: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un material, incluida su imagen (opcional).
     *
     * @param Material $material
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Material $material, Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:60',
            'description' => 'required|string|max:100',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required'        => 'Debe introducir el nombre del material.',
            'description.required' => 'Debe introducir la descripción del material.',
            'image.image'          => 'El fichero debe ser una imagen.',
            'image.mimes'          => 'Solo se aceptan jpeg, png, jpg, gif o svg.',
            'image.max'            => 'La imagen no puede superar 2 MB.',
        ]);

        $oldPath = $material->image_path;
        $newPath = null;

        try {
            DB::transaction(function() use ($material, $request, $validated, &$newPath, $oldPath) {
                if ($request->hasFile('image')) {
                    $newPath = $request->file('image')->store('materials', 'public');
                }

                $material->update([
                    'name'        => $validated['name'],
                    'description' => $validated['description'],
                    'image_path'    =>  $newPath ?? $oldPath,
                ]);

                // Eliminar imagen antigua si se subió una nueva
                if (!empty($newPath) && !empty($oldPath)) {
                    StorageFacade::disk('public')->delete($oldPath);
                }
            });

            return back()->with('success', 'Material editado correctamente.');
        } catch (\Exception $e) {
            // Si hubo error, eliminar imagen subida
            if (!empty($newPath)) {
                StorageFacade::disk('public')->delete($newPath);
            }

            return back()->with('error', 'Error al editar el material: ' . $e->getMessage());
        }
    }

    /**
     * Sube una imagen temporal y devuelve su ruta para uso posterior.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadTemp(Request $request)
    {
        $request->validate(['image'=>'required|image|max:2048']);
        $tempPath = $request->file('image')->store('temp','public');
        return response()->json(['tempPath'=>$tempPath ?? null]);
    }
}
