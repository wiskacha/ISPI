<?php

use App\Http\Controllers\{
    LoginController,
    HomeController,
    LogoutController,
};
use Illuminate\Support\Facades\Route;


// Rutas de Administrador (role: admin)
Route::middleware('role:admin')->group(function () {
    // Incluir las rutas de clientes
    require_once base_path('routes/admin/clientes.php');
    
    // Incluir las rutas de usuarios
    require_once base_path('routes/admin/usuarios.php');
    
    // Incluir las rutas de productos
    require_once base_path('routes/admin/productos.php');

    //Incluir las rutas de empresas
    require_once base_path('routes/admin/empresas.php');

    //Incluir las rutas de contactos
    require_once base_path('routes/admin/contactos.php');

    //Incluir las rutas de almacenes
    require_once base_path('routes/admin/almacenes.php');
    
    //Incluir las rutas de recintos
    require_once base_path('routes/admin/recintos.php');

    //Incluir las rutas de movimientos
    require_once base_path('routes/admin/movimientos.php');

    //Incluir las rutas de generación de recibos
    require_once base_path('routes/admin/pdf.php');
});

// Rutas de Usuario Autenticado
Route::middleware('auth')->group(function () {});

// Rutas de Páginas Genéricas
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

// Ruta del Dashboard
Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

// Rutas de Visitante (Sin autenticación)
Route::match(['get', 'post'], '/', [HomeController::class, 'show']);
Route::view('/landing', 'landing');
Route::view('/login', 'landing');
Route::get('/logout', [LogoutController::class, 'logout']);

// Rutas de Autenticación
Route::get('/login', [HomeController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
