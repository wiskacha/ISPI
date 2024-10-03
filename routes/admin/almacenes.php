<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmaceneController;

// Gestión de Almacens
Route::prefix('almacenes')->group(function () {
    // Mostrar lista de almacenes
    Route::get('/vista', [AlmaceneController::class, 'index'])->name('almacenes.vista');

    // Página para registrar almacen
    Route::get('/registro', [AlmaceneController::class, 'register'])->name('almacenes.registro');

    // Registrar almacen en la base de datos
    Route::post('/register', [AlmaceneController::class, 'store'])->name('almacenes.store');

    // Mostrar formulario para editar almacen
    Route::get('/{id_almacen}/edit', [AlmaceneController::class, 'edit'])->name('almacenes.edit');

    // Actualizar información de la almacen
    Route::put('/{id_almacen}', [AlmaceneController::class, 'update'])->name('almacenes.update');

    // Eliminar almacen de la base de datos
    Route::delete('/{id}', [AlmaceneController::class, 'destroy'])->name('almacenes.destroy');
});
