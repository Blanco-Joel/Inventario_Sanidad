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
     * Muestra la vista principal de gestión de materiales.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('materials.dashboard');
    }
    
    /**
     * Muestra la vista para dar de alta (agregar) nuevos materiales.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createForm()
    {
        return view('materials.create');
    }

    /**
     * Agrega un nuevo material a la cesta para dar de alta.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCreationBasket(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required',
            'description'           => 'required',
            'storage'               => 'required',
            'units_use'             => 'required|integer|min:1',
            'min_units_use'         => 'required|integer|min:1',
            'cabinet_use'           => 'required|integer|min:1',
            'shelf_use'             => 'required|integer|min:1',
            'drawer'                => 'required|integer|min:1',
            'units_reserve'         => 'required|integer|min:1',
            'min_units_reserve'     => 'required|integer|min:1',
            'cabinet_reserve'       => 'required|string',
            'shelf_reserve'         => 'required|integer|min:1',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required'               => 'Debe introducir el nombre del material.',
            'description.required'        => 'Debe introducir la descripción del material.',
            'storage.required'            => 'Debe introducir la localización.',
            'units_use.required'          => 'Debe introducir la cantidad para uso.',
            'min_units_use.required'      => 'Debe introducir la cantidad mínima para uso.',
            'cabinet_use.required'        => 'Debe introducir el armario para uso.',
            'shelf_use.required'          => 'Debe introducir la balda para uso.',
            'drawer.required'             => 'Debe introducir el cajón para uso.',
            'units_reserve.required'      => 'Debe introducir la cantidad para reserva.',
            'min_units_reserve.required'  => 'Debe introducir la cantidad mínima para reserva.',
            'cabinet_reserve.required'    => 'Debe introducir el armario para reserva.',
            'shelf_reserve.required'      => 'Debe introducir la balda para reserva.',
            'image.image'                 => 'El fichero debe ser una imagen.',
            'image.mimes'                 => 'Sólo se aceptan imágenes jpeg, png, jpg, gif o svg.',
            'image.max'                   => 'La imagen no puede superar 2 MB.',
        ]);

        $tempPath = null;

        if ($request->hasFile('image')) {
            $tempPath = $request->file('image')->store('temp', 'public');
        }

        $basket = Cookie::get('materialsAddBasket', '[]');
        $basket = json_decode($basket, true);

        if (!is_array($basket)) {
            $basket = [];
        }

        $basket[] = [
            'name'          => $validated['name'],
            'description'   => $validated['description'],
            'storage'       => $validated['storage'],
            'image_temp'    => $tempPath,
            'use' => [
                'units'         => $validated['units_use'],
                'min_units'     => $validated['min_units_use'],
                'cabinet'       => $validated['cabinet_use'],
                'shelf'         => $validated['shelf_use'],
                'drawer'        => $validated['drawer']
            ],
            'reserve' => [
                'units'         => $validated['units_reserve'],
                'min_units'     => $validated['min_units_reserve'],
                'cabinet'       => $validated['cabinet_reserve'],
                'shelf'         => $validated['shelf_reserve'],
                'drawer'        => null
            ],
        ];

        Cookie::queue('materialsAddBasket', json_encode($basket), 1440);

        return back()->with('success', 'Material agregado a la cesta.');
    }

    /**
     * Da de alta los materiales que se han almacenado temporalmente en la cookie 
     * 'materialsAddBasket'. Si ocurre un error no se da de alta ningún material.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBatch()
    {
        $basket = json_decode(Cookie::get('materialsAddBasket', '[]'), true);
    
        if (empty($basket) || !is_array($basket)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de alta.');
        }

        $imagesMaterials = [];
    
        try {
            DB::transaction(function () use ($basket, &$imagesMaterials) {
                foreach ($basket as $materialData) {
                    $material = new Material();
                    $material->name = $materialData["name"];
                    $material->description = $materialData["description"];
                    $material->image_path = null;
                    $material->save();

                    if (!empty($materialData["image_temp"])) {
                        $imageName = pathinfo($materialData["image_temp"], PATHINFO_BASENAME);
                        $imagesMaterials[] = [
                            'material_id'   =>  $material->material_id,
                            'image_temp'    =>  $materialData["image_temp"],
                            'image_path'    =>  "materials/{$imageName}",
                        ];
                    }
                    
                    $this->storeMaterialInStorage($material, $materialData);
                }
            });

            foreach ($imagesMaterials as $imageData) {
                StorageFacade::disk('public')->move($imageData["image_temp"], $imageData["image_path"]);
                Material::where('material_id', $imageData["material_id"])->update(['image_path' =>  $imageData["image_path"]]);
            }

            StorageFacade::disk('public')->deleteDirectory('temp');

            Cookie::queue(Cookie::forget('materialsAddBasket'));
    
            return back()->with('success', 'Materiales incorporados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al insertar los materiales: ' . $e->getMessage());
        }
    }    

    /**
     * Da de alta o registra el almacenamiento de cada material creado.
     * @param \App\Models\Material $material
     * @param mixed $materialData
     * @return void
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
     * Muestra la vista para dar de baja (eliminar) materiales.
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function deleteForm()
    {
        //return view('materials.delete')->with('materials', Material::all())->paginate(10);
        return view('materials.delete')->with('materials', Material::simplePaginate(5));
    }

    /**
     * Agrega un material a la cesta para dar de baja, almacenando su ID.
     * @param \Illuminate\Http\Request $request
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

        $basket = Cookie::get('materialsRemovalBasket', '[]');
        $basket = json_decode($basket, true);
        
        if (!is_array($basket)) {
            $basket = [];
        }

        $material = Material::findOrFail($validated['material']);

        $basket[] = [
            'material_id' => $material->material_id,
            'name'        => $material->name
        ];
        
        Cookie::queue('materialsRemovalBasket', json_encode($basket), 1440);
        
        return back()->with('success', 'Material agregado a la cesta.');
    }

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

    public function edit()
    {
        return view('materials.edit');
    }
    public function materialsData()
    {
        return response()->json(Material::All());
    }
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

                if (!empty($newPath) && !empty($oldPath)) {
                    StorageFacade::disk('public')->delete($oldPath);
                }
            });

            return back()->with('success', 'Material editado correctamente.');
        } catch (\Exception $e) {
            if (!empty($newPath)) {
                StorageFacade::disk('public')->delete($newPath);
            }

            return back()->with('error', 'Error al editar el material: ' . $e->getMessage());
        }
    }
}
