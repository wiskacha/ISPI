<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteController;

Route::prefix('reportes')->group(function () {

    Route::get('/vista-generar', [ReporteController::class, 'index'])->name('recintos.vista');

    Route::post('/reporte-generado', [ReporteController::class, 'generarReporte'])->name('reportes.reportegenerado');

    Route::post('/reporte-generado/imprimir-desglose',[ReporteController::class, 'imprimirDesglose'])->name('reportes.imprimirDesglose');

    Route::post('/reporte-generado/imprimir-desglose-productos',[ReporteController::class, 'imprimirDesglosePorProducto'])->name('reportes.imprimirDesglosePorProducto');

    // Route::get('/create', function () {
    //     return view('reportes.create');
    // });

    // Route::post('/', function () {
    //     // Logic to store report
    // });

    // Route::get('/{id}', function ($id) {
    //     return view('reportes.show', ['id' => $id]);
    // });

    // Route::get('/{id}/edit', function ($id) {
    //     return view('reportes.edit', ['id' => $id]);
    // });

    // Route::put('/{id}', function ($id) {
    //     // Logic to update report
    // });

    // Route::delete('/{id}', function ($id) {
    //     // Logic to delete report
    // });
});
