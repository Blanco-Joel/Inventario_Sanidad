<?php

namespace App\Http\Controllers;

use App\Models\Modification;
use App\Models\Storage;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class StorageController extends Controller
{
    public function updateView()
    {
        //return view('storages.update')->with('storages', Storage::all());
        $materials = Material::with('storage')->get();
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
                'use_quantity'         => 'required|integer|min:1',
                'use_min_quantity'     => 'required|integer|min:1',
                'use_cabinet'          => 'required|integer|min:1',
                'use_shelf'            => 'required|integer|min:1',
    
                'reserve_quantity'     => 'required|integer|min:1',
                'reserve_min_quantity' => 'required|integer|min:1',
                'reserve_cabinet'      => 'required|integer|min:1',
                'reserve_shelf'        => 'required|integer|min:1',

                'onlyReserve'          => 'boolean'
            ]);
    
            // Registro actuales.
            $useRecord = $material->storage->where('storage_type', 'use')->first();
            $reserveRecord = $material->storage->where('storage_type', 'reserve')->first();

            // Nuevos valores.
            $newUseQuantity    = $validated['use_quantity'];
            $newUseMin         = $validated['use_min_quantity'];
            $newUseCabinet     = $validated['use_cabinet'];
            $newUseShelf       = $validated['use_shelf'];

            $newReserveQuantity = $validated['reserve_quantity'];
            $newReserveMin     = $validated['reserve_min_quantity'];
            $newReserveCabinet = $validated['reserve_cabinet'];
            $newReserveShelf   = $validated['reserve_shelf'];

            // Comprueba si ningún campo cambia.
            if
            (
                $newUseQuantity    == $useRecord->quantity && 
                $newUseMin         == $useRecord->min_quantity && 
                $newUseCabinet     == $useRecord->cabinet && 
                $newUseShelf       == $useRecord->shelf && 
                $newReserveQuantity == $reserveRecord->quantity && 
                $newReserveMin     == $reserveRecord->min_quantity && 
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
                    $newReserveQuantity == $reserveRecord->quantity && 
                    $newReserveMin     == $reserveRecord->min_quantity && 
                    $newReserveCabinet == $reserveRecord->cabinet && 
                    $newReserveShelf   == $reserveRecord->shelf
                )
                {
                    return back()->with('info', 'No se han detectado cambios en los datos de reserva.');
                }

                // Calcular la diferencia a registrar.
                $differenceReserve = $newReserveQuantity - $reserveRecord->quantity;
                // Comprobar stock negativo.
                if ($newReserveQuantity < 0) {
                    return back()->with('error','La cantidad de reserva no puede ser negativa.');
                }

                DB::transaction(function() use ($validated, $newReserveQuantity, $differenceReserve, $material) {
                    // Actualizar reserva.
                    Storage::where('material_id', $material->material_id)->where('storage_type' , 'reserve')
                    ->update([
                        'quantity'     => $newReserveQuantity,
                        'min_quantity' => $validated['reserve_min_quantity'],
                        'cabinet'      => $validated['reserve_cabinet'],
                        'shelf'        => $validated['reserve_shelf'],
                    ]);
            
                    // Registrar modificación.
                    $this->storeEditInModification($material->material_id, 'reserve', $differenceReserve);
                });

                return back()->with('success','Se ha actualizado correctamente el almacenamiento de reserva.');
            }
    
            // Diferencias.
            $differenceUse     = $newUseQuantity     - $useRecord->quantity;
            $differenceReserve = $newReserveQuantity - $reserveRecord->quantity;
    
            // Si cambia ambas unidades, no se realiza el cambio.
            if ($differenceUse !== 0 && $differenceReserve !== 0) {
                return back()->with('error','Solo puedes modificar una de las dos cantidades; el otro valor se ajustará automáticamente.');
            }
    
            if ($differenceUse !== 0) {
                // Cambiar la cantidad de reserva.
                $newReserveQuantity  = $reserveRecord->quantity - $differenceUse;
                if ($newReserveQuantity < 0) {
                    return back()->with('error','No puedes transferir más unidades de las que hay en reserva.');
                }
            } else if ($differenceReserve !== 0) {
                // Cambiar la cantidad de uso.
                $newUseQuantity  = $useRecord->quantity - $differenceReserve;
                if ($newUseQuantity < 0) {
                    return back()->with('error','No puedes transferir más unidades de las que hay en uso.');
                }
            }
    
            DB::transaction(function() use ($validated, $newUseQuantity, $newReserveQuantity, $differenceUse, $differenceReserve, $material) {
                // Actualizar uso.
                Storage::where('material_id', $material->material_id)->where('storage_type' , 'use')
                ->update([
                    'quantity'     => $newUseQuantity,
                    'min_quantity' => $validated['use_min_quantity'],
                    'cabinet'      => $validated['use_cabinet'],
                    'shelf'        => $validated['use_shelf'],
                ]);
    
                // Actualizar reserva.
                Storage::where('material_id', $material->material_id)->where('storage_type' , 'reserve')
                ->update([
                    'quantity'     => $newReserveQuantity,
                    'min_quantity' => $validated['reserve_min_quantity'],
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

    private function storeEditInModification($material_id, $storage_type, $quantity)
    {
        $user_id = Cookie::get('USERPASS');
    
        Modification::create([
            'user_id'      => $user_id,
            'material_id'  => $material_id,
            'storage_type'=> $storage_type,
            'quantity'    => $quantity,
        ]);
    }
}