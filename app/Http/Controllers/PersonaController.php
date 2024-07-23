<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;

class PersonaController extends Controller
{
    public function index()
    {
        // Fetch data using Eloquent query builder
        $personas = Persona::selectRaw("
            CONCAT(nombre, ' ', papellido, ' ', COALESCE(sapellido, '')) AS NOMBRE,
            carnet AS CARNET,
            celular AS CELULAR
        ")->whereNull('deleted_at')->orderBy('updated_at', 'DESC')->get();

        // Pass data to view
        return view('pages.vistaClientes', ['personas' => $personas]);
    }
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

        // Pass data to view
        return view('pages.vistaUsuarios', ['personas' => $personas]);
    }
}
