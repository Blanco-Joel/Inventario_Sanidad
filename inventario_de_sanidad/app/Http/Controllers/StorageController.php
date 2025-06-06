<?php

namespace App\Http\Controllers;

use App\Models\Modification;
use App\Models\Storage;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;

class StorageController extends Controller
{
<<<<<<< HEAD
    /**
     * Muestra la vista principal de los almacenamientos.
     * Si es administrador vera los dos almacenamientos de uso y reserva.
     * Si es docente vera el almacenamiento de uso.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function updateView()
    {
        return view('storages.update');
=======
    // VISTAS

    public function updateView()
    {
        $storage = Storage::first();
        return view('storages.update')->with('storage', $storage);
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
    }

    /**
     * Muestra la vista del administrador para editar los almacenamientos de un material específico.
     * @param \App\Models\Material $material
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function editView(Material $material)
    {
        return view('storages.edit')->with('material', $material);
    }

<<<<<<< HEAD
    public function updateBatch(Request $request, Material $material, $currentLocation)
=======
    public function teacherEditView(Material $material)
    {
        return view('storages.teacher.edit')->with('material', $material);
    }

    public function show($cabinet, $shelf)
    {
        $storages = Storage::where('cabinet', $cabinet)
                           ->where('shelf', $shelf)
                           ->get();

        return view('storages.show', compact('storages', 'cabinet', 'shelf'));
    }

    /**
     * Procesa y actualiza los datos de almacenamiento (uso y/o reserva) de un material.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBatch(Request $request, Material $material)
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
    {
        $validated = $request->validate([
            'storage'           => 'required|string|in:CAE,odontology',
            'use_units'         => 'required|integer|min:0',
            'use_min_units'     => 'required|integer|min:0',
            'use_cabinet'       => 'required|integer|min:0',
            'use_shelf'         => 'required|integer|min:0',
            'drawer'            => 'required|integer|min:0',

            'reserve_units'     => 'required|integer|min:0',
            'reserve_min_units' => 'required|integer|min:0',
            'reserve_cabinet'   => 'required|string',
            'reserve_shelf'     => 'required|integer|min:0',

            'onlyReserve'       => 'nullable|boolean'
        ]);

        // Registro actuales.
        $useRecord = $material->storage->where('storage_type', 'use')->where('storage', $currentLocation)->first();
        $reserveRecord = $material->storage->where('storage_type', 'reserve')->where('storage', $currentLocation)->first();

        if (empty($useRecord)) {
            return back()->with('error', 'El material no está añadido en el almacenamiento de uso.');
        } else if (empty($reserveRecord)) {
            return back()->with('error', 'El material no está añadido en el almacenamiento de reserva.');
        }

        // Nuevos valores.
        $newLocation        = $validated['storage'];
        $newUseUnits        = $validated['use_units'];
        $newUseMin          = $validated['use_min_units'];
        $newUseCabinet      = $validated['use_cabinet'];
        $newUseShelf        = $validated['use_shelf'];
        $newUseDrawer       = $validated['drawer'];

        $newReserveUnits    = $validated['reserve_units'];
        $newReserveMin      = $validated['reserve_min_units'];
        $newReserveCabinet  = $validated['reserve_cabinet'];
        $newReserveShelf    = $validated['reserve_shelf'];

        if ($currentLocation !== $newLocation) {
            $noChangeLocation = $material->storage->where('storage', $newLocation)->first();
            if (!empty($noChangeLocation)) {
                return back()->with('error', "El material ya está añadido en el almacén de $newLocation.");
            }
        }

        // Comprueba si ningún campo cambia.
        if
        (
            $newLocation        == $currentLocation &&
            $newUseUnits        == $useRecord->units && 
            $newUseMin          == $useRecord->min_units && 
            $newUseCabinet      == $useRecord->cabinet && 
            $newUseShelf        == $useRecord->shelf && 
            $newUseDrawer       == $useRecord->drawer &&
            $newReserveUnits    == $reserveRecord->units && 
            $newReserveMin      == $reserveRecord->min_units && 
            $newReserveCabinet  == $reserveRecord->cabinet && 
            $newReserveShelf    == $reserveRecord->shelf
        )
        {
            return back()->with('info', 'No se han detectado cambios en los datos.');
        }

        try {
<<<<<<< HEAD
=======
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

            if (empty($useRecord)) {
                return back()->with('error', 'El material no esta añadido en el alamcenamiento de uso.');
            } else if (empty($reserveRecord)) {
                return back()->with('error', 'El material no esta añadido en el alamcenamiento de uso.');
            }
            
            // Nuevos valores.
            $newStorage = $validated['storage'];
            $newUseUnits    = $validated['use_units'];
            $newUseMin         = $validated['use_min_units'];
            $newUseCabinet     = $validated['use_cabinet'];
            $newUseShelf       = $validated['use_shelf'];
            $newUseDrawer       = $validated['drawer'];

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
                $newUseDrawer       ==  $useRecord->drawer &&
                $newReserveUnits == $reserveRecord->units && 
                $newReserveMin     == $reserveRecord->min_units && 
                $newReserveCabinet == $reserveRecord->cabinet && 
                $newReserveShelf   == $reserveRecord->shelf
            )
            {
                return back()->with('info', 'No se han detectado cambios en los datos.');
            }

>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
            // Solamente actualizar reserva.
            if ($request->boolean('onlyReserve')) {
                // Calcular la diferencia a registrar.
                $differenceReserve = $newReserveUnits - $reserveRecord->units;

                // Comprobar stock negativo.
                if (abs($differenceReserve) > $reserveRecord->units && $reserveRecord->units > 0) {
                    return back()->with('error','La cantidad de reserva no puede ser negativa.');
                }

                DB::transaction(function() use ($validated, $newReserveUnits, $differenceReserve, $material, $newLocation, $currentLocation) {
                    // Actualizar reserva.
                    Storage::where('material_id', $material->material_id)
                    ->where('storage_type' , 'reserve')
                    ->where('storage', $currentLocation)
                    ->update([
                        'units'     => $newReserveUnits,
                        'min_units' => $validated['reserve_min_units'],
                        'cabinet'   => $validated['reserve_cabinet'],
                        'shelf'     => $validated['reserve_shelf'],
                        'storage'   => $newLocation
                    ]);

                    // Registrar modificación.
                    $this->storeEditInModification($material->material_id, 'reserve', $differenceReserve, $currentLocation);
                });

                $this->comprobateUnits($material, 'reserve', $currentLocation);

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
    
            DB::transaction(function() use ($validated, $newUseUnits, $newReserveUnits, $differenceUse, $differenceReserve, $material, $currentLocation) {
                // Actualizar uso.
                Storage::where('material_id', $material->material_id)
                ->where('storage_type' , 'use')
                ->where('storage', $currentLocation)
                ->update([
                    'storage' => $validated['storage'],
                    'units'     => $newUseUnits,
                    'min_units' => $validated['use_min_units'],
                    'cabinet'      => $validated['use_cabinet'],
                    'shelf'        => $validated['use_shelf'],
                    'drawer'        =>  $validated['drawer']
                ]);
    
                // Actualizar reserva.
                Storage::where('material_id', $material->material_id)
                ->where('storage_type' , 'reserve')
                ->where('storage', $currentLocation)
                ->update([
                    'storage' => $validated['storage'],
                    'units'     => $newReserveUnits,
                    'min_units' => $validated['reserve_min_units'],
                    'cabinet'      => $validated['reserve_cabinet'],
                    'shelf'        => $validated['reserve_shelf'],
                ]);
        
                if ($differenceUse !== 0) {
                    // Si differenceUse ≠ 0, registramos differenceUse en 'use' y -differenceUse en 'reserve'.
                    $this->storeEditInModification($material->material_id, 'use', $differenceUse,$currentLocation);
                    $this->storeEditInModification($material->material_id, 'reserve', -$differenceUse, $currentLocation);
                } else if ($differenceReserve !== 0) {
                    // Si differenceReserve ≠ 0, registramos differenceReserve en 'reserve' y -differenceReserve en 'use'.
                    $this->storeEditInModification($material->material_id, 'reserve', $differenceReserve, $currentLocation);
                    $this->storeEditInModification($material->material_id, 'use', -$differenceReserve, $currentLocation);
                }
            });

            $this->comprobateUnits($material, 'use', $currentLocation);
            $this->comprobateUnits($material, 'reserve', $currentLocation);
    
            return back()->with('success','Almacenamiento actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al modificar los registros: ' . $e->getMessage());
        }
    }

    /**
<<<<<<< HEAD
     * Registra las unidades modificadas de un material y almacenamiento específico.
     * @param mixed $material_id
     * @param mixed $storage_type
     * @param mixed $units
     * @return void
     */
    private function storeEditInModification($material_id, $storage_type, $units, $currentLocation)
=======
     * Registra una modificación en la tabla de historial de cambios.
     *
     * @param int $material_id     | ID del material
     * @param string $storage_type | Tipo de almacenamiento ('use' o 'reserve')
     * @param int $units           | Cantidad modificada (puede ser negativa)
     * @return void
     */
    private function storeEditInModification($material_id, $storage_type, $units)
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
    {
        $user_id = Cookie::get('USERPASS');

        Modification::create([
            'user_id'           => $user_id,
            'material_id'       => $material_id,
            'storage_type'      => $storage_type,
            'storage'           => $currentLocation,  
            'units'             => $units,
            'action_datetime'   => Carbon::now('Europe/Madrid'),
        ]);
    }

    /**
<<<<<<< HEAD
     * Muestra la vista del docente para editar el almacenamiento de uso de un material específico.
     * @param \App\Models\Material $material
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function teacherEditView(Material $material)
    {
        return view('storages.teacher.edit')->with('material', $material);
    }

    /**
     * Resta unidades en uso para un material.
=======
     * Resta unidades al almacenamiento de uso de un material.
     *
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\RedirectResponse
     */
<<<<<<< HEAD
    public function subtractToUse(Request $request, Material $material, $currentLocation)
    {
        try {
            $useRecord     = $material->storage->where('storage_type', 'use')->where('storage', $currentLocation)->first();
            $currentUse      = $useRecord->units;
=======
    public function subtractToUse(Request $request, Material $material)
    {
        try {
            $useRecord  = $material->storage->where('storage_type', 'use')->first();
            $currentUse = $useRecord->units;
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599

            $validated = $request->validate([
                'subtract_units' => "required|integer|min:1|max:{$currentUse}",
            ], [
                'subtract_units.required' => 'Debes indicar cuántas unidades transferir.',
                'subtract_units.integer'  => 'La cantidad debe ser un número entero.',
                'subtract_units.min'      => 'Debes restar al menos 1 unidad.',
                'subtract_units.max'      => "Solo hay {$currentUse} unidades disponibles en uso.",
            ]);

            $modifiedUnits = $validated['subtract_units'];

<<<<<<< HEAD
            DB::transaction(function() use ($modifiedUnits, $material, $currentLocation) {
=======
            DB::transaction(function() use ($modifiedUnits, $material) {
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
                Storage::where('material_id',$material->material_id)
                ->where('storage_type','use')
                ->where('storage', $currentLocation)
                ->decrement('units',$modifiedUnits);
        
                $this->storeEditInModification($material->material_id, 'use', -$modifiedUnits, $currentLocation);
            });

            $this->comprobateUnits($material, 'use', $currentLocation);

            return back()->with('success',"Se han restado {$modifiedUnits} unidades.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al modificar los registros: ' . $e->getMessage());
        }
    }

    /**
<<<<<<< HEAD
     * Comprueba las unidades de un material en un tipo de almacenamiento.
     * Si las unidades disponibles son inferiores al mínimo, se envía una advertencia por correo.
     * @param mixed $material
     * @param mixed $storage_type
     * @return void
     */
    private function comprobateUnits($material, $storage_type, $currentLocation)
=======
     * Comprueba si el número de unidades en el almacenamiento está por debajo del mínimo
     * y, en tal caso, envía una alerta por correo electrónico.
     *
     * @param \App\Models\Material $material
     * @param string $storage_type Tipo de almacenamiento ('use' o 'reserve')
     * @return void
     */
    private function comprobateUnits($material, $storage_type)
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
    {
        $typeRecord = Storage::where('material_id', $material->material_id)
        ->where('storage_type', $storage_type)
        ->where('storage', $currentLocation)->first();

        if ($typeRecord->units < $typeRecord->min_units) {
            Mail::to('docente@instituto.com')->send(new LowStockAlert($typeRecord, $material->name));
        }
    }

    /**
<<<<<<< HEAD
     * Devuelve los materiales que están en un armario y balda específico.
     * @param mixed $cabinet
     * @param mixed $shelf
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($cabinet, $shelf)
    {
        $storages = Storage::where('cabinet', $cabinet)->where('shelf',   $shelf)->get();

        return view('storages.show', compact('storages', 'cabinet', 'shelf'));
=======
     * Devuelve en JSON la lista de todos los materiales.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateData()
    {
        return response()->json(Material::with('storage')->get());
>>>>>>> f6c9f1c0172e0b7bc5646b183d931c4bfd9e2599
    }
}