<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

Route::prefix('movimientos')->group(function () {

    Route::get('/generar-recibo/{id_movimiento}', [MovimientoController::class, 'previewRecibo'])->name('movimientos.previewRecibo');
    Route::get('/descargar-recibo/{id_movimiento}', [MovimientoController::class, 'downloadRecibo'])->name('movimientos.downloadRecibo');
});
