<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeDocentesController extends Controller
{
    public function showWelcome_docentes()
    {
        return view('welcome_docentes');
    }
}

