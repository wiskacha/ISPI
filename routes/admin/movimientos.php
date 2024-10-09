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

    // Eliminar las Cuotas relacionadas con el movimiento
    Route::delete('/{movimiento}/cuotas', [MovimientoController::class, 'cuotasDestroy'])
        ->name('movimientos.cuotasDestroy');

    // Pagar una cuota
    Route::get('/{cuota}/pagar', [MovimientoController::class, 'payCuota'])
        ->name('movimientos.payCuota');

    // Resetear una cuota
    Route::get('/{cuota}/resetear', [MovimientoController::class, 'resetCuota'])
        ->name('movimientos.resetCuota');

    // Route for checking product availability
    Route::post('/check-product-availability', [MovimientoController::class, 'verificarStock'])
        ->name('movimientos.checkAvailability');

    // Route for checking contacto relationship between producto and proveedor
    Route::post('/check-contacto-relationship', [MovimientoController::class, 'verificarContacto'])
        ->name('movimientos.checkContacto');

    // Route for checking cuotas existence with the movimiento
    Route::get('/{id}/check-cuotas', [MovimientoController::class, 'checkCuotas'])
        ->name('movimientos.checkCuotas');

    // Route for editPage of the Detalles of the Movimiento
    Route::get('/{movimiento}/editDetalles', [MovimientoController::class, 'editDetalles'])->name('movimientos.editDetalles');

    // Route for updating the Detalles of the Movimient
    Route::post('/{id_movimiento}/guardarDetalles', [MovimientoController::class, 'guardarDetalles'])->name('movimientos.guardarDetalles');

    // Route for deleting a Detalle of the Movimiento
    Route::post('/{id_movimiento}/eliminarDetalle/{id_detalle}', [MovimientoController::class, 'eliminarDetalle'])
        ->name('movimientos.eliminarDetalle');

    //NUEVA RUTA PRA GUARDAR DETALLE DE FORMA INDIVIDUAL
    Route::post('/{id_movimiento}/guardarDetalle', [MovimientoController::class, 'guardarDetalle'])->name('movimientos.guardarDetalle');

    //NUEVA RUTA PARA ACUTALIZAR EL VALOR DE UN DETALLE DE FORMA INDIVIDUAL
    Route::post('/{id_movimiento}/actualizarDetalle', [MovimientoController::class, 'actualizarDetalle'])->name('movimientos.actualizarDetalle');
});
