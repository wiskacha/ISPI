<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

// Gestión de Empresas
Route::prefix('empresas')->group(function () {
    // Mostrar lista de empresas
    Route::get('/vista', [EmpresaController::class, 'index'])->name('empresas.vista');

    // Página para registrar empresa
    Route::get('/registro', [EmpresaController::class, 'register'])->name('empresas.registro');

    // Registrar empresa en la base de datos
    Route::post('/register', [EmpresaController::class, 'store'])->name('empresas.store');

    // Mostrar formulario para editar empresa
    Route::get('/{id_empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');

    // Actualizar información de la empresa
    Route::put('/{id_empresa}', [EmpresaController::class, 'update'])->name('empresas.update');

    // Eliminar empresa de la base de datos
    Route::delete('/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
});
