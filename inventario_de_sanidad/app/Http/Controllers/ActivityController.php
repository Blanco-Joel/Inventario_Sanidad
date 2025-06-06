<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\MaterialActivity;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Muestra la vista para crear una nueva actividad
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function createForm()
    {
        return view('activities.create')->with('materials', Material::all());
    }

    /**
     * Registra la actividad.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required',
            'activity_datetime'=> 'required|date',
            'materialsBasketInput' => 'required'
        ], [
            'title.required'  => 'Debe introducir la descripción de la actividad.',
            'activity_datetime.required' => 'Debe introducir la fecha y hora de la actividad.',
            'materialsBasketInput.required' => 'Debe introducir datos a la cesta'
        ]);
    
        $basket = json_decode($validated['materialsBasketInput'], true) ?? [];

        if (!is_array($basket)) {
            $basket = [];
        }
    
        $user_id = Cookie::get('USERPASS');

        try {
            DB::transaction(function () use ($basket, $validated, $user_id) {
                $activity = new Activity();
                $activity->user_id = $user_id;
                $activity->title = $validated['title'];
                $activity->created_at = $validated['activity_datetime'];
                $activity->save();
        
                $this->storeMaterialsActivity($activity, $basket);
            });

            Cookie::queue(Cookie::forget('materialsBasket'));

            return back()->with('success', 'Actividad insertada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al insertar la actividad: ' . $e->getMessage());
        }
    }    

    /**
     * Registra los materiales utilizados en la actividad.
     * @param \App\Models\Activity $activity
     * @param mixed $basket
     * @return void
     */
    private function storeMaterialsActivity(Activity $activity, $basket)
    {
        foreach ($basket as $data) {
            MaterialActivity::create([
                'activity_id' => $activity->activity_id,
                'material_id' => $data['material_id'],
                'units'    => $data['units']
            ]);
        }
    }

    /**
     * Muestra una vista con todas las actividades del usuario(alumno).
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function historyView()
    {
        $user = User::find(Cookie::get('USERPASS'));
        $activities = $user->activities()
            ->with('materials')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('activities.history')->with('activities', $activities);
    }
}
