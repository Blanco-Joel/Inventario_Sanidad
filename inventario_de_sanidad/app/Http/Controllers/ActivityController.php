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
     * Muestra el formulario de creación de actividades con la lista de materiales disponibles.
     *
     * @return \Illuminate\View\View
     */
    public function createForm()
    {
        $teachers = User::where('user_type', 'teacher')->get();

        return view('activities.create')->with('materials', Material::all())->with('teachers',$teachers);
    }
    /**
     * Devuelve todas las actividades en formato JSON ordenados por fecha de creación descendente.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activityData()
    {
         $user = User::find(Cookie::get('USERPASS'));
        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.');
        }
        
        $activities = $user->activities()
            ->with('materials','teacher')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($activities);
    } 
    public function activityTeacherData()
    {
        $user = User::find(Cookie::get('USERPASS'));
        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.');
        }
        
        $activities = Activity::with('materials','teacher')
                    ->where('teacher_id',$user->user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return response()->json($activities);
    } 
    /**
     * Muestra el historial de actividades del usuario autenticado.
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function historyView()
    {
        $user = User::find(Cookie::get('USERPASS'));
        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.');
        }
        
        $activities = $user->activities()
            ->with('materials')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('activities.history')->with('activities', $activities);
    }

    /**
     * Almacena una nueva actividad y sus materiales asociados en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required',
            'activity_datetime'=> 'required|date',
            'teacher_id'=> 'required',
            'materialsBasketInput' => 'required'
        ], [
            'title.required'  => 'Debe introducir la descripción de la actividad.',
            'activity_datetime.required' => 'Debe introducir la fecha y hora de la actividad.',
            'teacher_id.required' =>'Debe introducir el nombre del profesor',
            'materialsBasketInput.required' => 'Debe introducir datos a la cesta'
        ]);
        
        $basket = json_decode($validated['materialsBasketInput'], true) ?? [];
    
        $user_id = Cookie::get('USERPASS');
        if (!$user_id || !User::find($user_id)) {
            return back()->with('error', 'Usuario no válido.');
        }

        try {
            DB::transaction(function () use ($basket, $validated, $user_id) {
                $activity = new Activity();
                $activity->user_id = $user_id;
                $activity->title = $validated['title'];
                $activity->teacher_id = $validated['teacher_id'];
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
     * Almacena la relación entre una actividad y los materiales utilizados.
     *
     * @param  \App\Models\Activity  $activity
     * @param  array  $basket
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
}
