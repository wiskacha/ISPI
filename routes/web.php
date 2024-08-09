<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;

// Dashboard route
Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

// Rutas de Administrador
Route::middleware(['role:admin'])->group(function () {
    Route::get('/vista-usuarios', [PersonaController::class, 'users']);
});

// Rutas de Usuario
Route::middleware(['auth'])->group(function () {
    //PERSONAS
        //CLIENTES: 
    Route::get('/personas/clientes/vista', [PersonaController::class, 'index'])->name('personas.clientes.vistaClientes');
    Route::get('/personas/clientes/registro', [PersonaController::class, 'registerpage'])->name('personas.clientes.registroClientes');
    Route::post('/personas/clientes/register', [PersonaController::class, 'register']);
    Route::post('/personas/clientes/register', [PersonaController::class, 'register'])->name('personas.register');

        //
    Route::delete('/personas/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy');
    Route::view('/pages/slick', 'pages.slick');
    Route::view('/pages/datatables', 'pages.datatables');
    Route::view('/pages/blank', 'pages.blank');
    
});

// Rutas de Visitante
Route::view('/', 'landing');
Route::view('/login', 'landing');
Route::get('/logout', [LogoutController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [HomeController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
