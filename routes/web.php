<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\ReciboController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('splade')->group(function () {
    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/verificar/{hash}', [ReciboController::class, 'verificar'])->name('recibo.verificar');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/inicio', [InicioController::class, 'inicio'])->middleware(['verified'])->name('inicio');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::group(['prefix' => 'admin'], function () {
            Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
            Route::get('/users', UserController::class)->name('users')->middleware('can:users');
            Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('can:user.create');
            Route::post('/user', [UserController::class, 'store'])->name('user.store')->middleware('can:user.store');
            Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
            Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
            Route::get('/user/{user}/email_confirm', [UserController::class, 'email_confirm'])->name('user.email_confirm');
            Route::get('/user/{user}/active', [UserController::class, 'active'])->name('user.active');
            Route::post('/user/{user}/persona', [UserController::class, 'storePersona'])->name('user.persona.store');
            Route::put('/user/{user}/persona', [UserController::class, 'updatePersona'])->name('user.persona.update');

            Route::get('/roles', RoleController::class)->name('roles');
            Route::get('/rol/create', [RoleController::class, 'create'])->name('rol.create');
            Route::post('/rol', [RoleController::class, 'store'])->name('rol.store');
            Route::get('/rol/{rol}', [RoleController::class, 'show'])->name('rol.show');
            Route::get('/rol/{id}/edit', [RoleController::class, 'edit'])->name('rol.edit');
            Route::put('/rol/{id}', [RoleController::class, 'update'])->name('rol.update');
        });

        Route::get('/personas', [PersonaController::class, 'index'])->name('personas');

        Route::get('/persona/create', [PersonaController::class, 'create'])->name('persona.create');
        Route::get('/persona/{persona}', [PersonaController::class, 'show'])->name('persona.show');
        Route::post('/persona', [PersonaController::class, 'store'])->name('persona.store');
        Route::get('/persona/{persona}/edit', [PersonaController::class, 'edit'])->name('persona.edit');
        Route::put('/persona/{persona}', [PersonaController::class, 'update'])->name('persona.update');

        Route::get('/inmuebles', [InmuebleController::class, 'index'])->name('inmuebles');
        Route::get('/inmueble/create', [InmuebleController::class, 'create'])->name('inmueble.create');
        Route::post('/inmueble', [InmuebleController::class, 'store'])->name('inmueble.store');
        Route::get('/inmueble/{inmueble}/edit', [InmuebleController::class, 'edit'])->name('inmueble.edit');
        Route::put('/inmueble/{inmueble}', [InmuebleController::class, 'update'])->name('inmueble.update');
        Route::delete('/inmueble/{inmueble}', [InmuebleController::class, 'destroy'])->name('inmueble.destroy');

        Route::get('/contratos', [ContratoController::class, 'index'])->name('contratos');
        Route::get('/contrato/create', [ContratoController::class, 'create'])->name('contrato.create');
        Route::post('/contrato', [ContratoController::class, 'store'])->name('contrato.store');
        Route::withoutMiddleware('splade')->group(function () {
            Route::get('/contrato/{contrato}', [ContratoController::class, 'show'])->name('contrato.show');
        });
        Route::get('/contrato/{contrato}/edit', [ContratoController::class, 'edit'])->name('contrato.edit');
        Route::put('/contrato/{contrato}', [ContratoController::class, 'update'])->name('contrato.update');
        Route::get('/contrato/{contrato}/anular', [ContratoController::class, 'anular'])->name('contrato.anular');
        Route::get('/contrato/{contrato}/renovar', [ContratoController::class, 'renovar'])->name('contrato.renovar');
        Route::delete('/contrato/{contrato}/archivos/{index}', [ContratoController::class, 'deleteArchivo'])->name('contrato.archivos.delete');

        Route::get('/recibos', [ReciboController::class, 'index'])->name('recibos');

        Route::get('/recibo/create', [ReciboController::class, 'create'])->name('recibo.create');
        Route::withoutMiddleware('splade')->group(function () {
            Route::get('/recibo/{recibo}', [ReciboController::class, 'show'])->name('recibo.show');
        });
        Route::post('/recibo', [ReciboController::class, 'store'])->name('recibo.store');
        Route::get('/recibo/{recibo}/edit', [ReciboController::class, 'edit'])->name('recibo.edit');
        Route::get('/recibo/{recibo}/edit-estado', [ReciboController::class, 'editEstado'])->name('recibo.edit-estado');
        Route::put('/recibo/{recibo}', [ReciboController::class, 'update'])->name('recibo.update');
    });




    require __DIR__ . '/auth.php';
});

// Fuera del grupo splade para permitir multipart/form-data sin intercepción de Splade
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/contrato/{contrato}/archivos', [ContratoController::class, 'uploadArchivos'])->name('contrato.archivos.upload');
});
