<?php

use App\Http\Livewire\Formularios\EdicionColaborador;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // ? Ruta Dashboard general
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // ? Rutas de colaboradores
    // * Panel
    Route::get('/panel-colaboradores', function () {
        return view('vistas-c.panelColaboradores');
    })->name('panel-colaboradores');
    // * Formulario registro
    Route::get('/registro-colaborador', function () {
        return view('vistas-c.registroColaborador');
    })->name('registro-colaborador');
    // * Formulario edicion
    Route::get('/edicion-colaborador/{id}', EdicionColaborador::class);

    // ? Rutas Facturas
    // * Panel administradores
    Route::get('/panel-facturas', function () {
        return view('vistas-c.panelFacturas');
    })->name('panel-facturas');
    // * Panel usuarios
    Route::get('/panel-facturas-usuarios', function () {
        return view('vistas-c.panelFacturasUsuarios');
    })->name('panel-facturas-usuarios');
});
