<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user' => 'required',
            'password' => 'required'
        ], [
            'user.required' => 'Debe introducir su número de usuario.',
            'password.required' => 'Debe introducir su contraseña.',
        ]);

        $user = Usuario::where('id_usuario', $credentials['user'])->first();
        if ($user && $user->nombre === $credentials['password']) {
            $type = $user->tipo_usuario;

            Cookie::queue('USERPASS', $user->id_usuario, 60);
            Cookie::queue('NAME', $user->nombre . " " . $user->apellidos, 60);
            Cookie::queue('TYPE', $type, 60);
            
            if ($type === 'docente') {
                return redirect()->route('welcome_docentes');
            } else {
                return redirect()->route('welcome_alumnos');
            }
        } else {
            return back()->withErrors(['login' => 'ERROR DE INICIO SESIÓN']);
        }
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('USERPASS'));
        Cookie::queue(Cookie::forget('NAME'));
        Cookie::queue(Cookie::forget('TYPE'));
        return redirect()->route('login.form');
    }
}
