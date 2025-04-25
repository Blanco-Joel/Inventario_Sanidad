<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacenamiento;
use App\Models\Materiales;



class WelcomeDocentesController extends Controller
{
    public function showWelcome_docentes()
    {
        $data = Almacenamiento::join('materiales', 'almacenamiento.id_material', '=', 'materiales.id_material')
            ->select('materiales.nombre', 'almacenamiento.unidades','tipo_almacen')
            ->whereColumn('almacenamiento.unidades','<','almacenamiento.min_unidades')
            ->get();
        return view('welcome_docentes',['data' => $data]);
    }
    public function welcome()
    {
        return view('welcome_docentes');
    }
}
