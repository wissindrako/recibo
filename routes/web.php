<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProfileController;
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
            Route::get('/users', UserController::class)->name('users')->middleware('can:users');
            Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('can:user.create');
            Route::post('/user', [UserController::class, 'store'])->name('user.store')->middleware('can:user.store');
            Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
            Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('/user/{id}/email_confirm', [UserController::class, 'email_confirm'])->name('user.email_confirm');
            Route::get('/user/{id}/active', [UserController::class, 'active'])->name('user.active');

            Route::get('/roles', RoleController::class)->name('roles');
            Route::get('/rol/{rol}', [RoleController::class, 'show'])->name('rol.show');
            Route::get('/rol/{id}/edit', [RoleController::class, 'edit'])->name('rol.edit');
            Route::put('/rol/{id}', [RoleController::class, 'update'])->name('rol.update');
        });

        Route::get('/personas', [PersonaController::class, 'index'])->name('personas');

        Route::get('/persona/create', [PersonaController::class, 'create'])->name('persona.create');
        Route::get('/persona/{id}', [PersonaController::class, 'show'])->name('persona.show');
        Route::post('/persona', [PersonaController::class, 'store'])->name('persona.store');
        Route::get('/persona/{id}/edit', [PersonaController::class, 'edit'])->name('persona.edit');
        Route::put('/persona/{id}', [PersonaController::class, 'update'])->name('persona.update');

        Route::get('/recibos', [ReciboController::class, 'index'])->name('recibos');

        Route::get('/recibo/create', [ReciboController::class, 'create'])->name('recibo.create');
        Route::withoutMiddleware('splade')->group(function () {
            Route::get('/recibo/{id}', [ReciboController::class, 'show'])->name('recibo.show');
        });
        Route::post('/recibo', [ReciboController::class, 'store'])->name('recibo.store');
        Route::get('/recibo/{id}/edit', [ReciboController::class, 'edit'])->name('recibo.edit');
        Route::put('/recibo/{id}', [ReciboController::class, 'update'])->name('recibo.update');
    });




    require __DIR__ . '/auth.php';
});
