<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class WelcomeController extends Controller
{

    public function changePasswordFirstLog(Request $request)
    {
        
        $credentials = $request->validate([
            'newPassword' => 'required',
            'confirmPassword' => 'required',
        ], [
            'newPassword.required' => 'Debe introducir el nombre.',
            'confirmPassword.required' => 'Debe introducir los apellidos.',
            'confirmPassword.same' => "Las contraseñas no coincdiden."
        ]);
        $user = User::where('user_id', Cookie::get('USERPASS'))->first();
        var_dump($user);
        $user->password             =  $credentials['newPassword'];
        $user->hashed_password      =  Hash::make($credentials['newPassword']);
        $user->save(); 
        
        return back()->with([
            'mensaje' => 'Contraseña actualizada con exito.',
        ]);
    }
    public function showWelcome_admin()
    {
        $data = Storage::join('materials', 'storage.material_id', '=', 'materials.material_id')
            ->select('materials.name', 'storage.units','storage_type')
            ->whereColumn('storage.units','<','storage.min_units')
            ->get();
        return view('welcome_admin',['data' => $data]);
    }
    public function showWelcome_docentes()
    {
        return view('welcome_docentes');
    }
    public function showWelcome_alumnos()
    {
        return view('welcome_alumnos');
    }
    public function welcome()
    {
        return view('welcome_docentes');
    }
}
