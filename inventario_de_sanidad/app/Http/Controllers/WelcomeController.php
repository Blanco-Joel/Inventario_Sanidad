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
        $user = User::where('user_id', Cookie::get('USERPASS'))->first();
        $data = [];

        if ($user && $user->type === 'admin') {
            $data = Storage::join('materials', 'storages.material_id', '=', 'materials.material_id')
                ->select('materials.name', 'storages.units', 'storage_type')
                ->whereColumn('storages.units', '<', 'storages.min_units')
                ->get();
        }

        return view('welcome.welcome', [
            'user' => $user,
            'data' => $data,
        ]);
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
