<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;
use App\Http\Requests\UpdateRequestUsuario;

class UserController extends Controller
{


    //VISTA DE USUARIOS
    public function index(Request $request)
    {
        $usuarios = User::with('persona') // Eager load de la relación 'persona'
            ->selectRaw("CONCAT(nick, ' / ', COALESCE(email, '')) AS NICKEMAIL, id") // Necesitamos 'id' para la relación
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC')
            ->get();

        // Map para agregar 'DUEÑO' (persona asociada) a cada usuario
        $usuarios->map(function ($usuario) {
            if ($usuario->persona) { // Verificamos si hay una persona relacionada
                $usuario->DUEÑO = "{$usuario->persona->nombre} {$usuario->persona->papellido} " . ($usuario->persona->sapellido ?? '');
            } else {
                $usuario->DUEÑO = 'No asignado'; // En caso de que no exista persona relacionada
            }
            return $usuario;
        });

        return view('pages.personas.usuarios.vistaUsuarios', ['usuarios' => $usuarios]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete(); // Soft delete
            return redirect()->route('personas.usuarios.vistaUsuarios')->with('success', 'Persona eliminada correctamente.');
        } else {
            return redirect()->route('personas.usuarios.vistaUsuarios')->with('error', 'Persona no encontrada.');
        }
    }


    public function editUsuario(User $user)
    {
        return view('pages.personas.usuarios.editarUsuario', compact('user'));
    }

    public function updateUsuario(UpdateRequestUsuario $request, User $user)
    {
        $user->update($request->validated()); // Update the instance with validated data

        return redirect()->route('personas.usuarios.vistaUsuarios')->with('success', 'Usuaio actualizado correctamente.');
    }
}


