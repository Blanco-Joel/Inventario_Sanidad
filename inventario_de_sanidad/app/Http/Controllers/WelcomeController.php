<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\Storage;
use App\Models\User;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return view('welcome.welcome');
    }

    public function firstLogData()
    {
        $userpass = Cookie::get('USERPASS');
        $user = User::where('user_id', $userpass)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

    public function changePasswordFirstLog(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        $userId = Cookie::get('USERPASS');
        if (!$userId) {
            return redirect()->back()->withErrors(['user' => 'Cookie de usuario no encontrada']);
        }

        $user = User::where('user_id', $userId)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'Usuario no encontrado']);
        }

        $user->password = $request->newPassword;
        $user->hashed_password = Hash::make($request->newPassword);
        $user->first_log = 1;
        $user->save();

        return redirect()->route('welcome')->with('mensaje', 'Contraseña actualizada con éxito.');
    }
}
