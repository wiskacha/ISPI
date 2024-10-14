<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\uMovimientoController;

Route::prefix('usuario')->group(function () {

    Route::get('/generar-recibo/{id_movimiento}', [uMovimientoController::class, 'previewRecibo'])
        ->name('usuario.previewRecibo');
    Route::get('/descargar-recibo/{id_movimiento}', [uMovimientoController::class, 'downloadRecibo'])
        ->name('usuario.downloadRecibo');
});
