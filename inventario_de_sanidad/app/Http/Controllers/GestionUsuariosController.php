<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class GestionUsuariosController extends Controller
{
    public function showGestionUsuarios()
    {
        $users = Usuario::select('id_usuario', 'nombre', 'apellidos','tipo_usuario')->get();
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
        $usuario = new Usuario();
        $usuario->nombre        =  $credentials["nombre"];
        $usuario->apellidos     =  $credentials["apellidos"];
        $usuario->email         =  $credentials["email"];
        $usuario->tipo_usuario  = $request->input('tipo_usuario');
        $usuario->save(); 
        
        return back()->with([
            'mensaje' => ' Usuario '.  $credentials["nombre"]. ' ' .  $credentials["apellidos"]. ' creado con exito.',
            'tab' => 'tab1'
        ]);
    }
    public function bajaUsers(Request $request)
    {
        $user = $request->input('bajaUsersSelect');
        Usuario::where('id_usuario', $user)->delete();

        return back()->with([
            'mensaje' => 'Usuario dado de baja con éxito.',
            'tab' => 'tab2'
        ]);
    }
}
