<?php

namespace App\Http\Controllers;

use App\Models\Modification;
use App\Models\Storage;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StorageController extends Controller
{
    public function updateView()
    {
        $materials = Material::with('storage')->simplePaginate(5);
        return view('storages.update')->with('storages', $materials);
    }

    public function editView(Material $material)
    {
        return view('storages.edit')->with('material', $material);
    }

    public function updateBatch(Request $request, Material $material)
    {
        try {
            $validated = $request->validate([
                'storage'   => 'required|string|in:CAE, odontología',
                'use_units'         => 'required|integer|min:1',
                'use_min_units'     => 'required|integer|min:1',
                'use_cabinet'          => 'required|integer|min:1',
                'use_shelf'            => 'required|integer|min:1',
                'drawer'    => 'required|integer|min:1',
    
                'reserve_units'     => 'required|integer|min:1',
                'reserve_min_units' => 'required|integer|min:1',
                'reserve_cabinet'      => 'required|string',
                'reserve_shelf'        => 'required|integer|min:1',

                'onlyReserve'          => 'boolean'
            ]);
    
            // Registro actuales.
            $useRecord = $material->storage->where('storage_type', 'use')->first();
            $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();

            // Nuevos valores.
            $newStorage = $validated['storage'];
            $newUseUnits    = $validated['use_units'];
            $newUseMin         = $validated['use_min_units'];
            $newUseCabinet     = $validated['use_cabinet'];
            $newUseShelf       = $validated['use_shelf'];

            $newReserveUnits = $validated['reserve_units'];
            $newReserveMin     = $validated['reserve_min_units'];
            $newReserveCabinet = $validated['reserve_cabinet'];
            $newReserveShelf   = $validated['reserve_shelf'];

            // Comprueba si ningún campo cambia.
            if
            (
                $newStorage == $useRecord->storage &&
                $newUseUnits    == $useRecord->units && 
                $newUseMin         == $useRecord->min_units && 
                $newUseCabinet     == $useRecord->cabinet && 
                $newUseShelf       == $useRecord->shelf && 
                $newReserveUnits == $reserveRecord->units && 
                $newReserveMin     == $reserveRecord->min_units && 
                $newReserveCabinet == $reserveRecord->cabinet && 
                $newReserveShelf   == $reserveRecord->shelf
            )
            {
                return back()->with('info', 'No se han detectado cambios en los datos.');
            }

            // Solamente actualizar reserva.
            if ($request->boolean('onlyReserve')) {
                if
                (
                    $newReserveUnits == $reserveRecord->units && 
                    $newReserveMin     == $reserveRecord->min_units && 
                    $newReserveCabinet == $reserveRecord->cabinet && 
                    $newReserveShelf   == $reserveRecord->shelf
                )
                {
                    return back()->with('info', 'No se han detectado cambios en los datos de reserva.');
                }

                // Calcular la diferencia a registrar.
                $differenceReserve = $newReserveUnits - $reserveRecord->units;
                // Comprobar stock negativo.
                if ($newReserveUnits < 0) {
                    return back()->with('error','La cantidad de reserva no puede ser negativa.');
                }

                DB::transaction(function() use ($validated, $newReserveUnits, $differenceReserve, $material) {
                    // Actualizar reserva.
                    Storage::where('material_id', $material->material_id)->where('storage_type' , 'reserve')
                    ->update([
                        'units'     => $newReserveUnits,
                        'min_units' => $validated['reserve_min_units'],
                        'cabinet'      => $validated['reserve_cabinet'],
                        'shelf'        => $validated['reserve_shelf'],
                    ]);
            
                    // Registrar modificación.
                    $this->storeEditInModification($material->material_id, 'reserve', $differenceReserve);
                });

                return back()->with('success','Se ha actualizado correctamente el almacenamiento de reserva.');
            }
    
            // Diferencias.
            $differenceUse     = $newUseUnits     - $useRecord->units;
            $differenceReserve = $newReserveUnits - $reserveRecord->units;
    
            // Si cambia ambas unidades, no se realiza el cambio.
            if ($differenceUse !== 0 && $differenceReserve !== 0) {
                return back()->with('error','Solo puedes modificar una de las dos cantidades; el otro valor se ajustará automáticamente.');
            }
    
            if ($differenceUse !== 0) {
                // Cambiar la cantidad de reserva.
                $newReserveUnits  = $reserveRecord->units - $differenceUse;
                if ($newReserveUnits < 0) {
                    return back()->with('error','No puedes transferir más unidades de las que hay en reserva.');
                }
            } else if ($differenceReserve !== 0) {
                // Cambiar la cantidad de uso.
                $newUseUnits  = $useRecord->units - $differenceReserve;
                if ($newUseUnits < 0) {
                    return back()->with('error','No puedes transferir más unidades de las que hay en uso.');
                }
            }
    
            DB::transaction(function() use ($validated, $newUseUnits, $newReserveUnits, $differenceUse, $differenceReserve, $material) {
                // Actualizar uso.
                Storage::where('material_id', $material->material_id)->where('storage_type' , 'use')
                ->update([
                    'storage' => $validated['storage'],
                    'units'     => $newUseUnits,
                    'min_units' => $validated['use_min_units'],
                    'cabinet'      => $validated['use_cabinet'],
                    'shelf'        => $validated['use_shelf'],
                ]);
    
                // Actualizar reserva.
                Storage::where('material_id', $material->material_id)->where('storage_type' , 'reserve')
                ->update([
                    'storage' => $validated['storage'],
                    'units'     => $newReserveUnits,
                    'min_units' => $validated['reserve_min_units'],
                    'cabinet'      => $validated['reserve_cabinet'],
                    'shelf'        => $validated['reserve_shelf'],
                ]);
        
                if ($differenceUse !== 0) {
                    // Si differenceUse ≠ 0, registramos differenceUse en 'use' y -differenceUse en 'reserve'.
                    $this->storeEditInModification($material->material_id, 'use', $differenceUse);
                    $this->storeEditInModification($material->material_id, 'reserve', -$differenceUse);
                } else if ($differenceReserve !== 0) {
                    // Si differenceReserve ≠ 0, registramos differenceReserve en 'reserve' y -differenceReserve en 'use'.
                    $this->storeEditInModification($material->material_id, 'reserve', $differenceReserve);
                    $this->storeEditInModification($material->material_id, 'use', -$differenceReserve);
                }
            });
    
            return back()->with('success','Almacenamiento actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al modificar los registros: ' . $e->getMessage());
        }
    }

    private function storeEditInModification($material_id, $storage_type, $units)
    {
        $user_id = Cookie::get('USERPASS');
        Modification::create([
            'user_id'         => $user_id,
            'material_id'     => $material_id,
            'storage_type'    => $storage_type,
            'units'           => $units,
            'action_datetime' => Carbon::now('Europe/Madrid'),
        ]);
    }

    public function teacherEditView(Material $material)
    {
        return view('storages.teacher.edit')->with('material', $material);
    }

    public function subtractToUse(Request $request, Material $material)
    {
        try {
            $useRecord     = $material->storage->where('storage_type', 'use')->first();
            $currentUse      = $useRecord->units;

            $validated = $request->validate([
                'subtract_units' => "required|integer|min:1|max:{$currentUse}",
            ], [
                'subtract_units.required' => 'Debes indicar cuántas unidades transferir.',
                'subtract_units.integer'  => 'La cantidad debe ser un número entero.',
                'subtract_units.min'      => 'Debes restar al menos 1 unidad.',
                'subtract_units.max'      => "Solo hay {$currentUse} unidades disponibles en uso.",
            ]);

            $modifiedUnits = $validated['subtract_units'];

            DB::transaction(function() use ($modifiedUnits, $material) {
                // decrementa uso
                Storage::where('material_id',$material->material_id)
                ->where('storage_type','use')
                ->decrement('units',$modifiedUnits);
        
                $this->storeEditInModification($material->material_id, 'use', -$modifiedUnits);
            });

            return back()->with('success',"Se han restado {$modifiedUnits} unidades.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al modificar los registros: ' . $e->getMessage());
        }
    }
}