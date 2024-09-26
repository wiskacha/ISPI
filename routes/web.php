<?php

use App\Http\Controllers\{
    LoginController,
    RegisterController,
    HomeController,
    LogoutController,
    PersonaController,
    UserController,
    AdjuntoController,
    ProductoController,
};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\{Persona, User};

// Ruta del Dashboard
Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'show']);

// Rutas de Administrador (role: admin)
Route::middleware('role:admin')->group(function () {

    // Gestión de Usuarios
    Route::get('/personas/usuarios/vista', [UserController::class, 'index'])->name('personas.usuarios.vistaUsuarios');
    Route::get('/personas/usuarios/{user}/edit', [UserController::class, 'editUsuario'])->name('personas.usuarios.editUsuario');
    Route::put('/personas/usuarios/{user}', [UserController::class, 'updateUsuario'])->name('personas.updateUsuario');

    // Registro de Usuarios
    Route::get('/personas/usuarios/registro', [UserController::class, 'registerpage'])->name('personas.usuarios.registroClientes');
    Route::get('/personas/usuarios/registroE', [UserController::class, 'registerpageE'])->name('personas.usuarios.create.existingUsuario');
    Route::get('/personas/usuarios/registroF', [UserController::class, 'registerpageF'])->name('personas.usuarios.create.freshUsuario');
    Route::post('/personas/usuarios/register', [UserController::class, 'register'])->name('personas.usuarios.register');
    Route::post('/personas/usuarios/registerE', [UserController::class, 'registerE'])->name('personas.usuarios.registerE');

    // Eliminar Usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Validación de campos dinámicos
    Route::get('/validate-nick', function (Request $request) {
        $userId = $request->query('id');
        $nick = $request->query('value');

        $exists = User::where('nick', $nick)
            ->where('id', '!=', $userId)
            ->exists();

        return response()->json(['exists' => $exists]);
    });

    Route::get('/validate-email', function (Request $request) {
        $userId = $request->query('id');
        $email = $request->query('value');

        $exists = User::where('email', $email)
            ->where('id', '!=', $userId)
            ->exists();

        return response()->json(['exists' => $exists]);
    });

    // Gestión de Productos
    Route::get('/productos/registro', [ProductoController::class, 'register'])->name('productos.registro');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::get('/productos/vista', [ProductoController::class, 'index'])->name('productos.vista');
    
    //Registro de Productos
    Route::post('/productos/register', [ProductoController::class, 'store'])->name('productos.store');
});

// Rutas de Usuario Autenticado
Route::middleware('auth')->group(function () {

    // Gestión de Clientes (Personas)
    Route::get('/personas/clientes/vista', [PersonaController::class, 'index'])->name('personas.clientes.vistaClientes');
    Route::get('/personas/clientes/registro', [PersonaController::class, 'registerpage'])->name('personas.clientes.registroClientes');
    Route::post('/personas/clientes/register', [PersonaController::class, 'register'])->name('personas.register');

    // Edición y Actualización de Clientes
    Route::get('/personas/{persona}/edit', [PersonaController::class, 'editCliente'])->name('persona.editCliente');
    Route::put('/personas/{persona}', [PersonaController::class, 'updateCliente'])->name('personas.updateCliente');

    // Eliminar Cliente
    Route::delete('/personas/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy');

    // Validación de campos dinámicos
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
});

// Rutas de Páginas Genéricas
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

// Rutas de Visitante (Sin autenticación)
Route::match(['get', 'post'], '/', [HomeController::class, 'show']);
Route::view('/landing', 'landing');
Route::view('/login', 'landing');
Route::get('/logout', [LogoutController::class, 'logout']);

// Rutas de Autenticación
Route::get('/login', [HomeController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
