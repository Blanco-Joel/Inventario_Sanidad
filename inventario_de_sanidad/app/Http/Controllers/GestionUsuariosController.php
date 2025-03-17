<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GestionUsuariosController extends Controller
{
    public function showGestionUsuarios()
    {
        return view('gestionUsuarios');
    }
}
