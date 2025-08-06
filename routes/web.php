<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ActivityLogger;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\ClaseInscripcionController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\HomeController;

//ruta para ejecutar el redireccionamiento con el logo de adminlte
Route::get('/admin/home', function () {
return view('admin.home');
})->name('admin.home');

Route::get('/cliente/home', function () {
return view('cliente.home');
})->name('cliente.home');

Route::get('/empleado/home', function () {
return view('empleado.home');
})->name('empleado.home');




// Página principal y aviso de privacidad
//Route::view('/', 'welcome');
Route::get('/', function () {
if (!Auth::check()) {
return view('welcome');
}
$rol = Auth::user()->rol;

return match ($rol) {
    'Admin' => redirect()->route('admin.home'),
    'Empleado' => redirect()->route('empleado.home'),
    'Cliente' => redirect()->route('cliente.home'),
    default => view('welcome'),
};
});

Route::view('/privacidad', 'privacidad');

// Login con Google
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Laravel Auth
Auth::routes();

// Pagos
Route::resource('pagos', App\Http\Controllers\PagoController::class);

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

     Route::middleware('rol:Empleado')->group(function () {
        Route::get('/clases_impartir', [ClasesController::class, 'list'])->name('clases.clases_impartir');
    });






    // Rutas para alumnos (rol: Cliente)
Route::middleware(['auth', 'rol:Cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    // Ver clases disponibles
    Route::get('/clases', [ClasesController::class, 'mostrarDisponibles'])->name('clases.disponibles');

    Route::get('/mis-clases', [ClaseInscripcionController::class, 'misClases'])->name('clases.mis');

    // Inscribirse en una clase
    Route::post('/clases/inscribirse/{claseId}', [ClaseInscripcionController::class, 'inscribirse'])->name('clases.inscribirse');
});

Route::middleware(['auth', 'rol:Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Listar
    Route::get('/clases-asignadas', [ClaseInscripcionController::class, 'listarTodasAsignaciones'])
        ->name('clases.listarAsignadas');

    // Crear
    Route::get('/asignar-clase', [ClaseInscripcionController::class, 'formAsignarClase'])
        ->name('clases.formAsignar');
    Route::post('/asignar-clase', [ClaseInscripcionController::class, 'asignarAUsuario'])
        ->name('clases.asignar');

    // Editar
    Route::get('/editar-asignacion/{id}', [ClaseInscripcionController::class, 'formEditarAsignacion'])
        ->name('clases.formEditar');
    Route::post('/editar-asignacion/{id}', [ClaseInscripcionController::class, 'editarAsignacion'])
        ->name('clases.editar');

    // Eliminar
    Route::delete('/eliminar-asignacion/{id}', [ClaseInscripcionController::class, 'eliminarAsignacion'])
        ->name('clases.eliminar');
});








    
    // CLIENTE: ver membresías
    Route::middleware('rol:Cliente,Admin')->group(function () {
        Route::get('/membresias_cliente', [MembresiaController::class, 'list'])->name('membresias.cliente');
    });
});
