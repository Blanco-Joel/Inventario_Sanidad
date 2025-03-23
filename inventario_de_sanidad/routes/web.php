<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeDocentesController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\GestionMaterialesController;

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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/welcome_docentes', [WelcomeDocentesController::class, 'showWelcome_docentes'])->name('welcome_docentes');

Route::get('/gestionUsuarios', [GestionUsuariosController::class, 'showGestionUsuarios'])->name('gestionUsuarios');
Route::post('/gestionUsuarios', [GestionUsuariosController::class, 'altaUsers'])->name('altaUsers.process');

Route::get('/gestionMateriales', [GestionMaterialesController::class, 'showGestionMateriales'])->name('gestionMateriales');

Route::get('/altaMaterial', [GestionMaterialesController::class, 'showAltaMateriales'])->name('altaMaterial.view');
Route::post('/altaMaterial/add', [GestionMaterialesController::class, 'agregarMaterialACestaAlta'])->name('add.process');
Route::post('/altaMaterial/process', [GestionMaterialesController::class, 'altaMaterial'])->name('altaMaterial.process');

Route::get('/bajaMaterial', [GestionMaterialesController::class, 'showBajaMateriales'])->name('bajaMaterial.view');
Route::post('/bajaMaterial/add', [GestionMaterialesController::class, 'agregarMaterialACestaBaja'])->name('add.process');
Route::post('/bajaMaterial/process', [GestionMaterialesController::class, 'bajaMaterial'])->name('bajaMaterial.process');
