<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class GestionUsuariosController extends Controller
{
    public function showGestionUsuarios()
    {
        return view('gestionUsuarios');
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
            'id_usuario' => 'required',
            'nombre' => 'required',
            'apellidos' => 'required'
        ], [
            'id_usuario.required' => 'Debe introducir un número de usuario.',
            'nombre.required' => 'Debe introducir el nombre.',
            'apellidos.required' => 'Debe introducir los apellidos.',
        ]);
        $usuario = new Usuario();
        $usuario->id_usuario =  $credentials["id_usuario"];
        $usuario->nombre =  $credentials["nombre"];
        $usuario->apellidos =  $credentials["apellidos"];
        $usuario->fecha_alta = date("Y-m-d") ;
        $usuario->tipo_usuario = $request->input('tipo_usuario');
        $usuario->save(); 
        
        return back()->with([
            'mensaje' => ' Usuario '.  $credentials["nombre"]. ' ' .  $credentials["apellidos"]. ' creado con exito.',
            'tab' => 'tab1'
        ]);
    }
    public function bajaUsers(Request $request)
    {
        return back()->with([
            'mensaje' => 'Usuario dado de baja con éxito.',
            'tab' => 'tab2'
        ]);
    }
}
