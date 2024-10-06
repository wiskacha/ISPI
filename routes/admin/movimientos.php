<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

// Gestión de Movimientos
Route::prefix('movimientos')->group(function () {

    // Mostrar lista de Movimientos
    Route::get('/vista', [MovimientoController::class, 'index'])->name('movimientos.vista');

    // Página para seleccionar el tipo de Movimiento
    Route::get('/registro', [MovimientoController::class, 'register'])->name('movimientos.registro');

    // Página para registrar Movimiento de ingreso
    Route::get('/ingreso', [MovimientoController::class, 'ingreso'])->name('movimientos.ingreso');

    // Página para registrar Movimiento de salida
    Route::get('/salida', [MovimientoController::class, 'salida'])->name('movimientos.salida');

    // Registro de Movimiento
    Route::post('/store', [MovimientoController::class, 'store'])->name('movimientos.store');

    // Eliminar Movimiento
    Route::delete('/{id}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy');

    // Actualizar Movimiento
    Route::put('/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update');

    // Mostrar formulario para editar Movimiento
    Route::get('/{movimiento}/edit', [MovimientoController::class, 'edit'])->name('movimientos.edit');

    // Display the view for assigning cuotas
    Route::get('/{id_movimiento}/asignar-cuotas', [MovimientoController::class, 'asignarCuotas'])
        ->name('movimientos.asignarCuotas');

    // Handle the form submission for storing cuotas
    Route::post('/cuotas/store', [MovimientoController::class, 'storeCuotas'])
        ->name('movimientos.storeCuotas');

    // Route for checking product availability
    Route::post('/check-product-availability', [MovimientoController::class, 'verificarStock'])
        ->name('movimientos.checkAvailability');

    // Route for checking contacto relationship between producto and proveedor
    Route::post('/check-contacto-relationship', [MovimientoController::class, 'verificarContacto'])
        ->name('movimientos.checkContacto');
});
