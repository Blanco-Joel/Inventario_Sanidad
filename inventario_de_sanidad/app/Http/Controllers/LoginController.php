<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


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

        $user = User::where('user_id', $credentials['user'])->first();
        if ($user && Hash::check($credentials['password'], $user->hashed_password)) {

            Cookie::queue('USERPASS', $user->user_id, 60);
            Cookie::queue('NAME', $user->first_name . " " . $user->last_name, 60);
            Cookie::queue('ROLE', $user->user_type, 60);
            
            if ($user->user_type === 'admin') {
                return redirect()->route('welcome_admin');
            } else if ($user->user_type === 'teacher') {
                return redirect()->route('welcome_teacher');
            } else {
                return redirect()->route('welcome_student');
            }
        } else {
            return back()->withErrors(['login' => 'ERROR DE INICIO SESIÓN']);
        }
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('USERPASS'));
        Cookie::queue(Cookie::forget('NAME'));
        Cookie::queue(Cookie::forget('ROLE'));
        return redirect()->route('login.form');
    }
}
