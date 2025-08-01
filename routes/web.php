<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ActivityLogger;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\HomeController;

// Página principal y aviso de privacidad
Route::view('/', 'welcome');
Route::view('/privacidad', 'privacidad');

// Login con Google
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Laravel Auth
Auth::routes();

Route::middleware(['auth', ActivityLogger::class])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ADMIN
    Route::middleware('rol:Admin')->group(function () {

        // Usuarios
        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UsuarioController::class, 'list'])->name('usuarios');
            Route::get('/nuevo', [UsuarioController::class, 'index'])->name('usuarios.nuevo');
            Route::post('/guardar', [UsuarioController::class, 'store'])->name('usuarios.guardar');
            Route::get('/editar/{id}', [UsuarioController::class, 'edit'])->name('usuarios.editar');
            Route::delete('/eliminar/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.eliminar');
        });

        // Membresías
        Route::prefix('membresias')->group(function () {
            Route::get('/', [MembresiaController::class, 'list'])->name('membresias.lista');
            Route::get('/nueva', [MembresiaController::class, 'create'])->name('membresias.nueva');
            Route::post('/guardar', [MembresiaController::class, 'store'])->name('membresias.guardar');
            Route::get('/editar/{id}', [MembresiaController::class, 'edit'])->name('membresias.editar');
            Route::delete('/eliminar/{id}', [MembresiaController::class, 'destroy'])->name('membresias.eliminar');
        });

        // Logs
        Route::prefix('logs')->group(function () {
            Route::get('/descargar', [LogsController::class, 'descargar'])->name('logs.descargar');
            Route::get('/mostrar', [LogsController::class, 'mostrar'])->name('logs.mostrar');
        });

        // Clases (crear/editar/borrar)
        Route::prefix('clases')->group(function () {
            Route::get('/nueva', [ClasesController::class, 'index'])->name('clases.nueva');
            Route::post('/guardar', [ClasesController::class, 'store'])->name('clases.guardar');
            Route::get('/editar/{id}', [ClasesController::class, 'edit'])->name('clases.editar');
            Route::delete('/eliminar/{id}', [ClasesController::class, 'destroy'])->name('clases.eliminar');
        });
    });

    // EMPLEADO: ver clases
    Route::middleware('rol:Empleado,Admin')->group(function () {
        Route::get('/clases', [ClasesController::class, 'list'])->name('clases');
    });

    // CLIENTE: ver membresías
    Route::middleware('rol:Cliente,Admin')->group(function () {
        Route::get('/membresias_cliente', [MembresiaController::class, 'list'])->name('membresias.cliente');
    });
});
