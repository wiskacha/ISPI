<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;
use App\Http\Requests\RegisterRequestCliente;

class PersonaController extends Controller
{

    //VISTA CLIENTES
    public function index(Request $request)
    {
        $excludeUsers = $request->get('exclude_users', false);

        $query = Persona::selectRaw("id_persona, 
        CONCAT(nombre, ' ', papellido, ' ', COALESCE(sapellido, '')) AS NOMBRE,
        carnet AS CARNET,
        celular AS CELULAR
    ")->whereNull('deleted_at');

        if ($excludeUsers) {
            // Add a condition to exclude users that are not soft-deleted
            $query->whereNotIn('id_persona', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->whereNull('deleted_at'); // Check that 'deleted_at' is NULL
            });
        }

        $personas = $query->orderBy('updated_at', 'DESC')->get();

        if ($request->ajax()) {
            $html = view('partials._personaTableRows', compact('personas'))->render();
            return response()->json(['html' => $html]);
        }

        return view('pages.personas.clientes.vistaClientes', ['personas' => $personas]);
    }

    //REGISTRO DE CLIENTES

    public function registerpage()
    {
        return view('pages.personas.clientes.registroClientes');
    }

    public function register(RegisterRequestCliente $request)
    {
        // Create a new persona using the validated request data
        $persona = Persona::create($request->validated());

        // Call the index method directly
        return redirect()->route('personas.clientes.vistaClientes')->with('success', 'Persona agregada correctamente.');
    }



    //VISTA DE USUARIOS
    public function users()
    {
        $personas = User::selectRaw("
        CONCAT(nick, ' / ', COALESCE(email, '')) AS NICKEMAIL, 
        CONCAT(personas.nombre, ' ', personas.papellido, ' ', COALESCE(personas.sapellido, '')) AS DUEÑO
    ")
            ->join('personas', 'users.id', '=', 'personas.id_persona')
            ->whereNull('users.deleted_at')
            ->orderBy('users.updated_at', 'DESC')
            ->get();
            return view('pages.personas.clientes.vistaClientes', ['personas' => $personas]);
    }

    public function destroy($id)
    {
        $persona = Persona::find($id);

        if ($persona) {
            $persona->delete(); // Soft delete
            return redirect()->route('personas.clientes.vistaClientes')->with('success', 'Persona eliminada correctamente.');
        } else {
            return redirect()->route('personas.clientes.vistaClientes')->with('error', 'Persona no encontrada.');
        }
    }
}
