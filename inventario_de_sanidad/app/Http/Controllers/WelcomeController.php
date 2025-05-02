<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function showWelcome_admin()
    {
        return view('welcome_admin');
    }

    public function showWelcome_teacher()
    {
        return view('welcome_teacher');
    }

    public function showWelcome_student()
    {
        return view('welcome_student');
    }
}
