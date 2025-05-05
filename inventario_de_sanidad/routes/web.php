<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StorageController;

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

Route::get('/welcome_admin', [WelcomeController::class, 'showWelcome_admin'])->name('welcome_admin');
Route::get('/welcome_teacher', [WelcomeController::class, 'showWelcome_teacher'])->name('welcome_teacher');
Route::get('/welcome_student', [WelcomeController::class, 'showWelcome_student'])->name('welcome_student');

Route::get('/gestionUsuarios', [GestionUsuariosController::class, 'showGestionUsuarios'])->name('gestionUsuarios');
Route::post('/gestionUsuarios', [GestionUsuariosController::class, 'altaUsers'])->name('altaUsers.process');

Route::prefix('materials')->group(function () {
    Route::get('/dashboard', [MaterialController::class, 'dashboard'])->name('materials.dashboard');

    Route::get('/create', [MaterialController::class, 'createForm'])->name('materials.create');

    Route::post('/basket/create', [MaterialController::class, 'addToCreationBasket'])->name('materials.basket.create');

    Route::post('/store', [MaterialController::class, 'storeBatch'])->name('materials.store');

    Route::get('/delete', [MaterialController::class, 'deleteForm'])->name('materials.delete');

    Route::post('/basket/delete', [MaterialController::class, 'addToDeletionBasket'])->name('materials.basket.delete');

    Route::post('/destroy', [MaterialController::class, 'destroyBatch'])->name('materials.destroyBatch');
});

Route::prefix('storages')->group(function () {
    Route::get('/update', [StorageController::class, 'updateView'])->name('storages.updateView');

    Route::get('update/{material}/edit', [StorageController::class, 'editView'])->name('storages.edit');

    Route::post('/update/{material}/process', [StorageController::class, 'updateBatch'])->name('storages.updateBatch');
});