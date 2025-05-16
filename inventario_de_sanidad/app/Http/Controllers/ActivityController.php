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
    public function createForm()
    {
        return view('activities.create')->with('materials', Material::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'  => 'required',
            'activity_datetime'=> 'required|date',
            'materialsBasketInput' => 'required'
        ], [
            'description.required'  => 'Debe introducir la descripción de la actividad.',
            'activity_datetime.required' => 'Debe introducir la fecha y hora de la actividad.',
            'materialsBasketInput.required' => 'Debe introducir datos a la cesta'
        ]);
    
        $basket = json_decode($validated['materialsBasketInput'], true) ?: [];

        if (!is_array($basket)) {
            $basket = [];
        }
    
        $user_id = Cookie::get('USERPASS');

        try {
            DB::transaction(function () use ($basket, $validated, $user_id) {
                $activity = new Activity();
                $activity->user_id = $user_id;
                $activity->description = $validated['description'];
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

    public function historyView()
    {
        $user = User::find(Cookie::get('USERPASS'));
        $activities = $user->activities()->with('materials')->get();
        return view('activities.history')->with('activities', $activities);
    }
}
