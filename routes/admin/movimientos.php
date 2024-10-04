<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

// Gestión de Movimientos
Route::prefix('movimientos')->group(function () {

    // Mostrar lista de Movimientos
    Route::get('/vista', [MovimientoController::class, 'index'])->name('movimientos.vista'); // Mostrar lista de Movimientos

    // Página para seleccionar el tipo de Movimiento
    Route::get('/registro', [MovimientoController::class, 'register'])->name('movimientos.registro'); // Página para seleccionar el tipo de Movimiento

    // Página para registrar Movimiento de ingreso
    Route::get('/ingreso', [MovimientoController::class, 'ingreso'])->name('movimientos.ingreso'); // Página para registrar Movimiento de ingreso

    // Página para registrar Movimiento de salida
    Route::get('/salida', [MovimientoController::class, 'salida'])->name('movimientos.salida'); // Página para registrar Movimiento de salida

    // Registro de Movimiento
    Route::post('/store', [MovimientoController::class, 'store'])->name('movimientos.store'); // Registrar Movimiento en la base de datos

    // Eliminar Movimiento
    Route::delete('/{id}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy'); // Eliminar Movimiento de la base de datos

    // Actualizar Movimiento
    Route::put('/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update'); // Actualizar la información de un Movimiento

    // Mostrar formulario para editar Movimiento
    Route::get('/{movimiento}/edit', [MovimientoController::class, 'edit'])->name('movimientos.edit'); // Mostrar formulario para editar Movimiento

});