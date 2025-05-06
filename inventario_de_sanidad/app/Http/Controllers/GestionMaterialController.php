<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GestionMaterialController extends Controller
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
            'name'                     => 'required',
            'description'              => 'required',
            'units_use'             => 'required|numeric|min:1',
            'min_units_use'         => 'required|numeric|min:1',
            'cabinet_use'              => 'required|numeric|min:1',
            'shelf_use'                => 'required|numeric|min:1',
            'units_reserve'         => 'required|numeric|min:1',
            'min_units_reserve'     => 'required|numeric|min:1',
            'cabinet_reserve'          => 'required|numeric|min:1',
            'shelf_reserve'            => 'required|numeric|min:1',
        ], [
            'name.required'                     => 'Debe introducir el nombre del material.',
            'description.required'              => 'Debe introducir la descripción del material.',
            'units_use.required'             => 'Debe introducir la cantidad para uso.',
            'min_units_use.required'         => 'Debe introducir la cantidad mínima para uso.',
            'cabinet_use.required'              => 'Debe introducir el armario para uso.',
            'shelf_use.required'                => 'Debe introducir la balda para uso.',
            'units_reserve.required'         => 'Debe introducir la cantidad para reserva.',
            'min_units_reserve.required'     => 'Debe introducir la cantidad mínima para reserva.',
            'cabinet_reserve.required'          => 'Debe introducir el armario para reserva.',
            'shelf_reserve.required'            => 'Debe introducir la balda para reserva.',
        ]);

        $basket = Cookie::get('materialsAddBasket', '[]');
        $basket = json_decode($basket, true);

        if (!is_array($basket)) {
            $basket = [];
        }

        $basket[] = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'use' => [
                'units'    => $validated['units_use'],
                'min_units'=> $validated['min_units_use'],
                'cabinet'     => $validated['cabinet_use'],
                'shelf'       => $validated['shelf_use'],
            ],
            'reserve' => [
                'units'    => $validated['units_reserve'],
                'min_units'=> $validated['min_units_reserve'],
                'cabinet'     => $validated['cabinet_reserve'],
                'shelf'       => $validated['shelf_reserve'],
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
        $basket = Cookie::get('materialsAddBasket', '[]');
        $basket = json_decode($basket, true);
    
        if (!is_array($basket)) {
            $basket = [];
        }
    
        if (empty($basket)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de alta.');
        }
    
        try {
            DB::transaction(function () use ($basket) {
                foreach ($basket as $materialData) {
                    $material = new Material();
                    $material->name = $materialData["name"];
                    $material->description = $materialData["description"];
                    $material->image_path = "images/" . $materialData["name"] . ".png";
                    $material->save();
                    
                    $this->storeMaterialInStorage($material, $materialData);
                }
            });
    
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
                'material_id'  => $material->material_id,
                'storage_type' => $type,
                'cabinet'      => $materialData[$type]['cabinet'],
                'shelf'        => $materialData[$type]['shelf'],
                'units'     => $materialData[$type]['units'],
                'min_units' => $materialData[$type]['min_units'],
            ]);
        }
    }
    
    /**
     * Muestra la vista para dar de baja (eliminar) materiales.
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function deleteForm()
    {
        return view('materials.delete')->with('materials', Material::all());
    }

    /**
     * Agrega un material a la cesta para dar de baja, almacenando su ID.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToDeletionBasket(Request $request)
    {
        $validated = $request->validate([
            'material' => 'required|exists:materials,material_id',
        ], [
            'material.required' => 'Debe seleccionar un material.',
            'material.exists'   => 'El material seleccionado no existe.',
        ]);

        $basket = Cookie::get('materialsRemovalBasket', '[]');
        $basket = json_decode($basket, true);
        
        if (!is_array($basket)) {
            $basket = [];
        }

        $material = Material::findOrFail($validated['material']);

        $basket[] = [
            'material_id' => $material->material_id,
            'name'        => $material->name,
        ];
        
        Cookie::queue('materialsRemovalBasket', json_encode($basket), 1440);
        
        return back()->with('success', 'Material agregado a la cesta.');
    }

    /**
     * Da de baja (elimina) los materiales cuyos IDs están almacenados en la cookie
     * 'materialsRemovalBasket'. Si ocurre un error no se da de baja ningún material.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBatch()
    {
        $basket = Cookie::get('materialsRemovalBasket', '[]');
        $basket = json_decode($basket, true);

        if (!is_array($basket)) {
            $basket = [];
        }

        if (empty($basket)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de baja.');
        }

        try {
            DB::transaction(function () use ($basket) {
                foreach ($basket as $materialData) {
                    $material = Material::find($materialData['material_id']);
                    if ($material) {
                        $material->delete();
                    }
                }
            });

            Cookie::queue(Cookie::forget('materialsRemovalBasket'));

            return back()->with('success', 'Materiales eliminados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar los materiales: ' . $e->getMessage());
        }
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

}
