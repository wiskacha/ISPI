<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;

// Gestión de Usuarios
Route::prefix('personas/usuarios')->group(function () {
    Route::get('/vista', [UserController::class, 'index'])->name('personas.usuarios.vistaUsuarios'); // Mostrar lista de usuarios
    Route::get('/{user}/edit', [UserController::class, 'editUsuario'])->name('personas.usuarios.editUsuario'); // Mostrar formulario para editar usuario
    Route::put('/{user}', [UserController::class, 'updateUsuario'])->name('personas.updateUsuario'); // Actualizar información del usuario

    // Registro de Usuarios
    Route::get('/registro', [UserController::class, 'registerpage'])->name('personas.usuarios.registroClientes'); // Página para registrar nuevo usuario
    Route::get('/registroE', [UserController::class, 'registerpageE'])->name('personas.usuarios.create.existingUsuario'); // Página para registrar usuario existente
    Route::get('/registroF', [UserController::class, 'registerpageF'])->name('personas.usuarios.create.freshUsuario'); // Página para registrar usuario nuevo
    Route::post('/register', [UserController::class, 'register'])->name('personas.usuarios.register'); // Registrar usuario en la base de datos
    Route::post('/registerE', [UserController::class, 'registerE'])->name('personas.usuarios.registerE'); // Registrar usuario existente en la base de datos

    // Eliminar Usuario
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Eliminar usuario de la base de datos
});

// Validación de campos dinámicos (Nick)
Route::get('/validate-nick', function (Request $request) {
    $userId = $request->query('id');
    $nick = $request->query('value');
    $exists = User::where('nick', $nick)
        ->where('id', '!=', $userId)
        ->exists();
    return response()->json(['exists' => $exists]); // Verificar si el nick ya existe
});

// Validación de campos dinámicos (Email)
Route::get('/validate-email', function (Request $request) {
    $userId = $request->query('id');
    $email = $request->query('value');
    $exists = User::where('email', $email)
        ->where('id', '!=', $userId)
        ->exists();
    return response()->json(['exists' => $exists]); // Verificar si el email ya existe
});
