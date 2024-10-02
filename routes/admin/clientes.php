<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use App\Models\Persona;

// Gestión de Clientes (Personas)
Route::prefix('personas/clientes')->group(function () {
    Route::get('/vista', [PersonaController::class, 'index'])->name('personas.clientes.vistaClientes'); // Mostrar lista de clientes
    Route::get('/registro', [PersonaController::class, 'registerpage'])->name('personas.clientes.registroClientes'); // Página para registrar clientes
    Route::post('/register', [PersonaController::class, 'register'])->name('personas.register'); // Registrar cliente en la base de datos

    // Edición y Actualización de Clientes
    Route::get('/{persona}/edit', [PersonaController::class, 'editCliente'])->name('persona.editCliente'); // Mostrar formulario para editar cliente
    Route::put('/{persona}', [PersonaController::class, 'updateCliente'])->name('personas.updateCliente'); // Actualizar información del cliente

    // Eliminar Cliente
    Route::delete('/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy'); // Eliminar cliente de la base de datos
});

// Validación de campos dinámicos (Carnet)
Route::get('/validate-carnet', function (Request $request) {
    $personaId = $request->query('persona_id');
    $carnet = $request->query('value');
    $exists = Persona::where('carnet', $carnet)
        ->where('id_persona', '!=', $personaId)
        ->exists();
    return response()->json(['exists' => $exists]); // Verificar si el carnet ya existe
});

// Validación de campos dinámicos (Celular)
Route::get('/validate-celular', function (Request $request) {
    $personaId = $request->query('persona_id');
    $celular = $request->query('value');
    $exists = Persona::where('celular', $celular)
        ->where('id_persona', '!=', $personaId)
        ->exists();
    return response()->json(['exists' => $exists]); // Verificar si el celular ya existe
});
