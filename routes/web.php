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
});



