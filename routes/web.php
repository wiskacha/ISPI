<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;







Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

//RUTAS DE ADMINISTRADOR
Route::get('/vista-clientes', [PersonaController::class, 'index']);
Route::middleware(['role:admin'])->group(function () {
    Route::get('/vista-usuarios', [PersonaController::class, 'users']);
});

//RUTAS DE USUARIO
Route::middleware(['auth'])->group(function () {

    Route::get('/vista-clientes', [PersonaController::class, 'index']);


    Route::view('/pages/slick', 'pages.slick');
    Route::view('/pages/datatables', 'pages.datatables');
    Route::view('/pages/blank', 'pages.blank');
});

//RUTAS DE VISITANTE
Route::view('/', 'landing');
Route::view('/login', 'landing');
Route::get('/logout', [LogoutController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'show']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [HomeController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);