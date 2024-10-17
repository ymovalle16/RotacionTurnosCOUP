<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaginaController;

/*
|-----------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas son cargadas por el RouteServiceProvider y todas se
| asignarán al grupo de middleware "web". ¡Haz algo grandioso!
|
*/

Route::get('/', function () {
    return view('funciones/login');
});

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/funciones/login', [AuthController::class, 'login'])->name('login');

// Ruta para manejar el inicio de sesión
Route::post('/login', [AuthController::class, 'validacion'])->name('validacion');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Rutas protegidas que requieren autenticación

Route::middleware(['auth'])->group(function () {
    Route::get('/index', [PaginaController::class, 'index'])->name('index');
    Route::get('/rotaciones', [PaginaController::class, 'rotaciones'])->name('rotaciones');
    Route::get('/ingresarOperador', [PaginaController::class, 'ingresarOperador'])->name('ingresarOperador');
    Route::post('/ingresarOperador', [PaginaController::class, 'ingresoOpe'])->name('ingresoOpe');
    Route::get('/ingresarBus', [PaginaController::class, 'ingresarBus'])->name('ingresarBus');
    Route::post('/ingresarBus', [PaginaController::class, 'ingresoBus'])->name('ingresoBus');
    Route::get('/editarOpe/{id}', [PaginaController::class, 'editarOpe'])->name('editarOpe');
    Route::put('/editarOpe/{id}', [PaginaController::class, 'actualizarOperador'])->name('actualizarOperador');
    Route::get('/editarBus/{id}', [PaginaController::class, 'editarBus'])->name('editarBus');
    Route::put('/editarBus/{id}', [PaginaController::class, 'actualizarBus'])->name('actualizarBus');
});



