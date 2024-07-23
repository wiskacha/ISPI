<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;
// Example Routes
Route::view('/', 'landing');
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

Route::get('/register', [RegisterController::class, 'show']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show']);

Route::post('/login', [LoginController::class, 'login']);

Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

Route::get('/logout', [LogoutController::class, 'logout']);

Route::get('/vista-clientes', [PersonaController::class, 'index']);
// Route::view('/pages/vista-clientes', 'pages.vistaClientes');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/vista-usuarios', [PersonaController::class, 'users']);
    // Add other admin routes here
});

Route::get('/admin', function () {
    return 'Admin Page';
})->middleware('role:admin');
