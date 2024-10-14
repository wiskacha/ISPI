<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\uClienteController;
use Illuminate\Http\Request;
use App\Models\Persona;

// Gestión de Clientes (Personas)
Route::prefix('usuario/ver-clientes')->group(function () {

    // Listar todos los clientes
    Route::get('/vista', [uClienteController::class, 'index'])->name('usuario.indexCl');

    Route::get('/registro', [uClienteController::class, 'registerpage'])->name('usuario.registerpageCl'); // Página para registrar clientes

    Route::post('/registro', [uClienteController::class, 'register'])->name('usuario.registerCl'); // Registrar un nuevo cliente
});