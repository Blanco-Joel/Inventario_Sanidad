<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\MaterialManagementController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\HistoricalManagementController;
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

/* WELCOME */
Route::get('/firstLogData', [WelcomeController::class, 'firstLogData']);
Route::get('/welcome', [WelcomeController::class, 'welcome'])->name('welcome');
Route::post('/welcome', [WelcomeController::class, 'changePasswordFirstLog'])->name('changePasswordFirstLog');

Route::middleware('check.teacher.cookie')->group(function () {
    // Rutas de almacenamiento de docentes
    Route::get('storages/update/{material}/teacher/edit', [StorageController::class, 'teacherEditView'])->name('storages.teacher.edit');
    Route::post('/storages/update/{material}/teacher/process', [StorageController::class, 'subtractToUse'])->name('storages.subtract.teacher');
});





Route::prefix('activities')->group(function () {
    Route::get('/create', [ActivityController::class, 'createForm'])->name('activities.create');

    Route::get('/history', [ActivityController::class, 'historyView'])->name('activities.history');

    Route::post('/store', [ActivityController::class, 'store'])->name('activities.store');
});



Route::middleware('check.admin.cookie')->group(function () {

    /* GESTION DE USUARIOS */

    Route::get('/users/usersManagement', [UsersManagementController::class, 'showUsersManagement'])->name('users.usersManagement');
    Route::post('/users/usersManagement/alta', [UsersManagementController::class, 'altaUsers'])->name('altaUsers.process');
    Route::post('/users/usersManagement/baja', [UsersManagementController::class, 'bajaUsers'])->name('bajaUsers.process');
    Route::get('/users/usersManagementData', function () {return response()->json(\App\Models\User::all());});
    
    /* MATERIALES EN RESERVA */

    Route::get('/historical/historicalSubmenu', [HistoricalManagementController::class, 'showHistoricalSubmenu'])->name('historical.historicalSubmenu');
    Route::get('/historical/historialModificaciones', [HistoricalManagementController::class, 'showModificationsHistorical'])->name('historical.modificationsHistorical');
    Route::get('/historical/{type}', [HistoricalManagementController::class, 'index'])
        ->where('type', 'reserve|use')
        ->name('historical.type');
    Route::prefix('storages')->group(function () {

        Route::get('/update', [StorageController::class, 'updateView'])->name('storages.updateView');
        Route::get('/updateData',function () {return response()->json(\App\Models\Material::with('storage')->get());});
        ;
    
        Route::get('update/{material}/edit', [StorageController::class, 'editView'])->name('storages.edit');
    
        Route::post('/update/{material}/process', [StorageController::class, 'updateBatch'])->name('storages.updateBatch');
    });
    Route::get('/bajaMaterial', [MaterialManagementController::class, 'showBajaMateriales'])->name('bajaMaterial.view');
    Route::post('/bajaMaterial/add', [MaterialManagementController::class, 'agregarMaterialACestaBaja'])->name('add.process');
    Route::post('/bajaMaterial/process', [MaterialManagementController::class, 'bajaMaterial'])->name('bajaMaterial.process');
    
    Route::prefix('materials')->group(function () {
        Route::get('/dashboard', [MaterialManagementController::class, 'dashboard'])->name('materials.dashboard');
        /* GESTION DE MATERIALES */
        //Route::get('/gestionMateriales', [MaterialManagementController::class, 'showGestionMateriales'])->name('gestionMateriales');
    
        Route::get('/create', [MaterialManagementController::class, 'createForm'])->name('materials.create');
    
        Route::post('/basket/create', [MaterialManagementController::class, 'addToCreationBasket'])->name('materials.basket.create');
    
        Route::post('/store', [MaterialManagementController::class, 'storeBatch'])->name('materials.store');
    
        Route::get('/delete', [MaterialManagementController::class, 'deleteForm'])->name('materials.delete');
    
        Route::post('/basket/delete', [MaterialManagementController::class, 'addToDeletionBasket'])->name('materials.basket.delete');
    
        //Route::post('/destroy', [MaterialManagementController::class, 'destroyBatch'])->name('materials.destroyBatch');
        Route::post('{material}/destroy', [MaterialManagementController::class, 'destroy'])->name('materials.destroy');
    });
    
});
