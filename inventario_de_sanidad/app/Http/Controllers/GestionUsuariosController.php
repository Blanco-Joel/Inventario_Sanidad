<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GestionUsuariosController extends Controller
{
    public function showGestionUsuarios()
    {
        $users = User::select('user_id', 'first_name', 'last_name','user_type')->get();
        return view('gestionUsuarios',['users' => $users]);
    }
    public function gestionUsuarios(Request $request) {
        if ($request->input('action') == 'alta') {
            altaUsers($request);
        } elseif ($request->input('action') == 'baja') {
            bajaUsers($request);
        }
    }
    public function altaUsers(Request $request)
    {
        $credentials = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required'
        ], [
            'nombre.required' => 'Debe introducir el nombre.',
            'apellidos.required' => 'Debe introducir los apellidos.',
            'email.required' => 'Debe introducir el email.'
        ]);
        $usuario = new User();
        $usuario->first_name        =  $credentials["nombre"];
        $usuario->last_name         =  $credentials["apellidos"];
        $usuario->email             =  $credentials["email"];
        $usuario->user_type         =  $request->input('user_type');
        $usuario->save(); 
        
        return back()->with([
            'mensaje' => ' Usuario '.  $credentials["nombre"]. ' ' .  $credentials["apellidos"]. ' creado con exito.',
            'tab' => 'tab1'
        ]);
    }
    public function bajaUsers(Request $request)
    {
        $user = $request->input('bajaUsersSelect');
        User::where('user_id', $user)->delete();

        return back()->with([
            'mensaje' => 'Usuario dado de baja con éxito.',
            'tab' => 'tab2'
        ]);
    }
}
