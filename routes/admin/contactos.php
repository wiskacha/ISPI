<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

// Gestión de Contactos
Route::prefix('contactos')->group(function () {

    // Mostrar lista de contactos
    Route::get('/vista', [ContactoController::class, 'index'])->name('contactos.vistaContactos');

    // Mostrar formulario para editar contacto
    Route::get('/edit/{persona}', [ContactoController::class, 'edit'])->name('contactos.edit');

    // Actualizar información del contacto
    Route::put('/{contacto}', [ContactoController::class, 'updateContacto'])->name('contactos.updateContacto');

    // Página para seleccionar opciones para registrar nuevo contacto 
    Route::get('/registro', [ContactoController::class, 'registerpage'])->name('contactos.registroContacto');

    // Página para registrar contacto con persona existente y empresa existente
    Route::get('/registroE', [ContactoController::class, 'registerpageE'])->name('contactos.create.existingContacto');

    // Página para registrar contacto con nueva persona y empresa existente
    Route::get('/registroF', [ContactoController::class, 'registerpageF'])->name('contactos.create.freshContacto');

    // Registrar contacto (nueva persona y empresa existente)
    Route::post('/register', [ContactoController::class, 'register'])->name('contactos.register');

    // Registrar contacto (persona existente y empresa existente)
    Route::post('/registerE', [ContactoController::class, 'registerE'])->name('contactos.registerE');

    //Registrar contactoE desde el modal del edición de contacto
    Route::post('/QregisterE', [ContactoController::class, 'QregisterE'])->name('contactos.QregisterE');

    // Eliminar contacto
    Route::delete('/{id_persona}/{id_empresa}', [ContactoController::class, 'destroy'])->name('contactos.destroy');
});
