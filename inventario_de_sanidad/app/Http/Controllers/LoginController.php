<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage as StorageFacade;
use App\Models\User;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
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

            Cookie::queue('USERPASS', $user->user_id, 1440);
            Cookie::queue('NAME', $user->first_name . " " . $user->last_name, 1440);
            Cookie::queue('EMAIL', $user->email, 1440);
            Cookie::queue('TYPE', $user->user_type, 1440);
            
            return redirect()->route('welcome');
            
        } else {
            return back()->withErrors(['login' => 'Usuario o contraseña incorrectos']);
        }
    }

    public function logout()
    {
        if (Cookie::get('TYPE') === 'admin') {
            StorageFacade::disk('public')->deleteDirectory('temp');
            Cookie::queue(Cookie::forget('materialsAddBasket'));
            Cookie::queue(Cookie::forget('materialsBasket'));
        }

        Cookie::queue(Cookie::forget('USERPASS'));
        Cookie::queue(Cookie::forget('NAME'));
        Cookie::queue(Cookie::forget('TYPE'));
        return redirect()->route('login.form');
    }
}
