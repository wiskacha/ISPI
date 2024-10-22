<?php

use App\Http\Controllers\{
    LoginController,
    HomeController,
    LogoutController,
};
use Illuminate\Support\Facades\Route;

// Visitor Routes (Unauthenticated)
Route::middleware('guest')->group(function () {
    Route::view('/landing', 'landing')->name('landing');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

});

Route::middleware('auth')->group(function () {

    require_once base_path('routes/email_verification.php');
    
    Route::match(['get', 'post'], '/', [HomeController::class, 'show'])->name('home');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'show'])->name('dashboard');
    // User-specific routes
    require_once base_path('routes/user/uclientes.php');
    require_once base_path('routes/user/umovimientos.php');
    require_once base_path('routes/user/pdf.php');
});


// Admin Routes (role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-specific routes
    require_once base_path('routes/admin/clientes.php');
    require_once base_path('routes/admin/usuarios.php');
    require_once base_path('routes/admin/productos.php');
    require_once base_path('routes/admin/empresas.php');
    require_once base_path('routes/admin/contactos.php');
    require_once base_path('routes/admin/almacenes.php');
    require_once base_path('routes/admin/recintos.php');
    require_once base_path('routes/admin/movimientos.php');
    require_once base_path('routes/admin/pdf.php');
    require_once base_path('routes/admin/reportes.php');
});

// Generic Pages
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
