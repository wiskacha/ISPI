<?php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Persona;
use App\Models\User;
use App\Http\Requests\RegisterRequestCliente;

class uClienteController extends Controller
{

    public function index(Request $request)
    {

        $personas = Persona::orderBy('updated_at', 'desc')->get();
        return view('pages.usuario.clientes.vistaClientes', compact('personas'));
    }

    public function registerpage()
    {
        return view('pages.usuario.clientes.registroCliente');
    }

    public function register(RegisterRequestCliente $request)
    {
        // Create a new persona using the validated request data
        $persona = Persona::create($request->validated());

        // Call the index method directly
        return redirect()->route('usuario.indexCl')->with('success', 'Persona agregada correctamente.');
    }
}
