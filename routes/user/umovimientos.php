<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\uMovimientoController;
use Illuminate\Http\Request;
use App\Models\Persona;

// Gestión de Clientes (Personas)
Route::prefix('usuario/movimientos')->group(function () {

    // Listar todos los clientes
    Route::get('/vista', [uMovimientoController::class, 'index'])->name('usuario.indexMv');

    Route::get('/registro', [uMovimientoController::class, 'register'])->name('usuario.registroMv');

    Route::get('/{movimiento}/edit', [uMovimientoController::class, 'edit'])->name('usuario.editMv');

    // Actualizar Movimiento
    Route::put('/{movimiento}', [uMovimientoController::class, 'update'])->name('usuario.updateMv');


    Route::post('/store', [uMovimientoController::class, 'store'])->name('usuario.storeMv');

    // Display the view for assigning cuotas
    Route::get('/{id_movimiento}/asignar-cuotas', [uMovimientoController::class, 'asignarCuotas'])
        ->name('usuario.asignarCuotas');

    Route::post('/cuotas/store', [uMovimientoController::class, 'storeCuotas'])
        ->name('usuario.storeCuotas');

    Route::get('/{id}/check-cuotas', [uMovimientoController::class, 'checkCuotas'])
        ->name('usuario.checkCuotas');

    Route::post('/check-product-availability', [uMovimientoController::class, 'verificarStock'])
        ->name('usuario.checkAvailability');

    Route::get('/{movimiento}/editDetalles', [uMovimientoController::class, 'editDetalles'])
        ->name('usuario.editDetalles');

    Route::post('/{id_movimiento}/guardarDetalles', [uMovimientoController::class, 'guardarDetalle'])
        ->name('usuario.guardarDetalle');

    Route::post('/{id_movimiento}/actualizarDetalle', [uMovimientoController::class, 'actualizarDetalle'])
        ->name('usuario.actualizarDetalle');

    Route::post('/{id_movimiento}/eliminarDetalle/{id_detalle}', [uMovimientoController::class, 'eliminarDetalle'])
        ->name('usuario.eliminarDetalle');
});
