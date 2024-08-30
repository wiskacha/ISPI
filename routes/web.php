<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;
// Dashboard route
Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

// Rutas de Administrador
Route::middleware(['role:admin'])->group(function () {
    Route::get('/vista-usuarios', [PersonaController::class, 'users']);
});

// Rutas de Usuario
Route::middleware(['auth'])->group(function () {
    //PERSONAS
    //CLIENTES: 
    Route::get('/personas/clientes/vista', [PersonaController::class, 'index'])->name('personas.clientes.vistaClientes');
    Route::get('/personas/clientes/registro', [PersonaController::class, 'registerpage'])->name('personas.clientes.registroClientes');
    Route::post('/personas/clientes/register', [PersonaController::class, 'register'])->name('personas.register');
    // Route to show the edit form
    Route::get('/personas/{persona}/edit', [PersonaController::class, 'editCliente'])->name('persona.editCliente');

    Route::get('/validate-carnet', function (Request $request) {
        $personaId = $request->query('persona_id');
        $carnet = $request->query('value');

        $exists = Persona::where('carnet', $carnet)
            ->where('id_persona', '!=', $personaId)
            ->exists();

        return response()->json(['exists' => $exists]);
    });

    Route::get('/validate-celular', function (Request $request) {
        $personaId = $request->query('persona_id');
        $celular = $request->query('value');

        $exists = Persona::where('celular', $celular)
            ->where('id_persona', '!=', $personaId)
            ->exists();

        return response()->json(['exists' => $exists]);
    });


    // Route to handle the update request
    Route::put('personas/{persona}', [PersonaController::class, 'updateCliente'])->name('personas.updateCliente');

    //
    Route::delete('/personas/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy');
    Route::view('/pages/slick', 'pages.slick');
    Route::view('/pages/datatables', 'pages.datatables');
    Route::view('/pages/blank', 'pages.blank');
});

// Rutas de Visitante
Route::match(['get', 'post'], '/', [HomeController::class, 'show']);
Route::view('/landing', 'landing');
Route::view('/login', 'landing');
Route::get('/logout', [LogoutController::class, 'logout']);


Route::get('/login', [HomeController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
