<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecintoController;

// Gestión de Recintos
Route::prefix('recintos')->group(function () {
    // Mostrar lista de recintos
    Route::get('/vista', [RecintoController::class, 'index'])->name('recintos.vista');

    // Página para registrar recinto
    Route::get('/registro', [RecintoController::class, 'register'])->name('recintos.registro');

    // Registrar recinto en la base de datos
    Route::post('/register', [RecintoController::class, 'store'])->name('recintos.store');

    // Mostrar formulario para editar recinto
    Route::get('/{id_recinto}/edit', [RecintoController::class, 'edit'])->name('recintos.edit');

    // Actualizar la información de un recinto
    Route::put('/{id_recinto}', [RecintoController::class, 'update'])->name('recintos.update');

    // Eliminar recinto de la base de datos
    Route::delete('/{id}', [RecintoController::class, 'destroy'])->name('recintos.destroy');
});