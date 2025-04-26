<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\GestionMaterialesController;
use App\Http\Controllers\MaterialReservaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* AUTENTIFICACION */
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


/* HOME */
Route::get('/welcome_docentes', [WelcomeController::class, 'showWelcome_docentes'])->name('welcome_docentes');
Route::get('/welcome_admin', [WelcomeController::class, 'showWelcome_admin'])->name('welcome_admin');
Route::get('/welcome_alumnos', [WelcomeController::class, 'showWelcome_alumnos'])->name('welcome_alumnos');


/* GESTION DE USUARIOS */
Route::get('/gestionUsuarios', [GestionUsuariosController::class, 'showGestionUsuarios'])->name('gestionUsuarios');
Route::post('/gestionUsuarios/alta', [GestionUsuariosController::class, 'altaUsers'])->name('altaUsers.process');
Route::post('/gestionUsuarios/baja', [GestionUsuariosController::class, 'bajaUsers'])->name('bajaUsers.process');


/* GESTION DE MATERIALES */
Route::get('/gestionMateriales', [GestionMaterialesController::class, 'showGestionMateriales'])->name('gestionMateriales');

Route::get('/altaMaterial', [GestionMaterialesController::class, 'showAltaMateriales'])->name('altaMaterial.view');
Route::post('/altaMaterial/add', [GestionMaterialesController::class, 'agregarMaterialACestaAlta'])->name('add.process');
Route::post('/altaMaterial/process', [GestionMaterialesController::class, 'altaMaterial'])->name('altaMaterial.process');

Route::get('/bajaMaterial', [GestionMaterialesController::class, 'showBajaMateriales'])->name('bajaMaterial.view');
Route::post('/bajaMaterial/add', [GestionMaterialesController::class, 'agregarMaterialACestaBaja'])->name('add.process');
Route::post('/bajaMaterial/process', [GestionMaterialesController::class, 'bajaMaterial'])->name('bajaMaterial.process');

/* MATERIALES EN RESERVA */
Route::get('/materiales/reserva', [MaterialReservaController::class, 'index'])->name('materiales.reserva');
