<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersManagementController extends Controller
{
    public function showUsersManagement()
    {
        $users = User::select('user_id','first_name', 'last_name', 'email', 'password', 'user_type','created_at')->get();
        return view('users.usersManagement',['users' => $users]);
    }
    public function gestionUsuarios(Request $request) {
        if ($request->input('action') == 'alta') {
            $this->altaUsers($request);
        } elseif ($request->input('action') == 'baja') {
            $this->bajaUsers($request);
        }
    }
    public function altaUsers(Request $request)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+[]{}|;:,.<>?';
        $password = '';
        
        for ($i = 0; $i < 8; $i++) {
            $password .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
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
        $usuario->first_name           =  $credentials["nombre"];
        $usuario->last_name            =  $credentials["apellidos"];
        $usuario->email                =  $credentials["email"];
        $usuario->password             =  $password;
        $usuario->hashed_password      =  Hash::make($password);
        $usuario->user_type            =  $request->input('user_type');
        $usuario->first_log            =  false;
        $usuario->created_at           =  Carbon::now('Europe/Madrid');
        $usuario->save(); 
        
        return back()->with([
            'mensaje' => ' Usuario '.  $credentials["nombre"]. ' ' .  $credentials["apellidos"]. ' creado con exito.',
            'tab' => 'tab1'
        ]);
    }
    public function bajaUsers(Request $request)
    {

        $user = $request["user_id"];
        User::where('user_id', $user)->delete();

        return back()->with([
            'mensaje' => 'Usuario dado de baja con éxito.',
            'tab' => 'tab2'
        ]);
    }
}
