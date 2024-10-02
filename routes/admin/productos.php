<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// Gestión de Productos
Route::prefix('productos')->group(function () {
    Route::get('/registro', [ProductoController::class, 'register'])->name('productos.registro'); // Página para registrar producto
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit'); // Mostrar formulario para editar producto
    Route::get('/vista', [ProductoController::class, 'index'])->name('productos.vista'); // Mostrar lista de productos

    // Registro de Productos
    Route::post('/register', [ProductoController::class, 'store'])->name('productos.store'); // Registrar producto en la base de datos

    // Eliminar Producto
    Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy'); // Eliminar producto de la base de datos

    // Actualizar Producto
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('productos.update'); // Actualizar información del producto
});
