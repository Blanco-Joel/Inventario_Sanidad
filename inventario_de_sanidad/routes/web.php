<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\GestionMaterialController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\MaterialReservaController;
use App\Http\Controllers\ActivityController;

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
Route::get('/firstLogData', function () {
    $userpass = Cookie::get('USERPASS'); // nombre de tu cookie
    return response()->json(
        \App\Models\User::where('user_id', $userpass)->first()
    );
});
Route::get('/welcome_docentes', [WelcomeController::class, 'showWelcome_docentes'])->name('welcome_teacher');
Route::post('/welcome_docentes', [WelcomeController::class, 'changePasswordFirstLog'])->name('changePasswordFirstLog');

Route::get('/welcome_admin', [WelcomeController::class, 'showWelcome_admin'])->name('welcome_admin');
Route::post('/welcome_admin', [WelcomeController::class, 'changePasswordFirstLog'])->name('changePasswordFirstLog');

Route::get('/welcome_alumnos', [WelcomeController::class, 'showWelcome_alumnos'])->name('welcome_student');
Route::post('/welcome_alumnos', [WelcomeController::class, 'changePasswordFirstLog'])->name('changePasswordFirstLog');


/* GESTION DE USUARIOS */
Route::get('/gestionUsuarios', [GestionUsuariosController::class, 'showGestionUsuarios'])->name('gestionUsuarios');
Route::post('/gestionUsuarios/alta', [GestionUsuariosController::class, 'altaUsers'])->name('altaUsers.process');
Route::post('/gestionUsuarios/baja', [GestionUsuariosController::class, 'bajaUsers'])->name('bajaUsers.process');
Route::get('/gestionUsuariosData', function () {return response()->json(\App\Models\User::all());});

Route::prefix('materials')->group(function () {
    Route::get('/dashboard', [GestionMaterialController::class, 'dashboard'])->name('materials.dashboard');
/* GESTION DE MATERIALES */
//Route::get('/gestionMateriales', [GestionMaterialController::class, 'showGestionMateriales'])->name('gestionMateriales');

    Route::get('/create', [GestionMaterialController::class, 'createForm'])->name('materials.create');

    Route::post('/basket/create', [GestionMaterialController::class, 'addToCreationBasket'])->name('materials.basket.create');

    Route::post('/store', [GestionMaterialController::class, 'storeBatch'])->name('materials.store');

    Route::get('/delete', [GestionMaterialController::class, 'deleteForm'])->name('materials.delete');

    Route::post('/basket/delete', [GestionMaterialController::class, 'addToDeletionBasket'])->name('materials.basket.delete');

    //Route::post('/destroy', [GestionMaterialController::class, 'destroyBatch'])->name('materials.destroyBatch');
    Route::post('{material}/destroy', [GestionMaterialController::class, 'destroy'])->name('materials.destroy');
});

Route::prefix('storages')->group(function () {
    Route::get('/update', [StorageController::class, 'updateView'])->name('storages.updateView');

    Route::get('update/{material}/edit', [StorageController::class, 'editView'])->name('storages.edit');
    Route::get('update/{material}/teacher/edit', [StorageController::class, 'teacherEditView'])->name('storages.teacher.edit');

    Route::post('/update/{material}/process', [StorageController::class, 'updateBatch'])->name('storages.updateBatch');
    Route::post('/update/{material}/teacher/process', [StorageController::class, 'subtractToUse'])->name('storages.subtract.teacher');
});

Route::prefix('activities')->group(function () {
    Route::get('/create', [ActivityController::class, 'createForm'])->name('activities.create');

    Route::post('/store', [ActivityController::class, 'store'])->name('activities.store');
});

Route::get('/bajaMaterial', [GestionMaterialController::class, 'showBajaMateriales'])->name('bajaMaterial.view');
Route::post('/bajaMaterial/add', [GestionMaterialController::class, 'agregarMaterialACestaBaja'])->name('add.process');
Route::post('/bajaMaterial/process', [GestionMaterialController::class, 'bajaMaterial'])->name('bajaMaterial.process');

/* MATERIALES EN RESERVA */
Route::get('/materiales/submenuHistorial', [MaterialReservaController::class,'showSubmenuHistorial' ])->name('materiales.submenuHistorial');
Route::get('/materiales/historialModificaciones', [MaterialReservaController::class,'showHistorialModificaciones' ])->name('materiales.historialModificaciones');
Route::get('/materiales/{tipo}', [MaterialReservaController::class, 'index'])
    ->where('tipo', 'reserva|uso')
    ->name('materiales.tipo');
