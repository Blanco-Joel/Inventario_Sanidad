<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Materials;



class WelcomeController extends Controller
{
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
