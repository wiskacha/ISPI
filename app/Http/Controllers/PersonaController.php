<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\User;
use App\Models\Movimiento;
use App\Models\Contacto;
use App\Http\Requests\RegisterRequestCliente;
use App\Http\Requests\UpdateRequestCliente;

class PersonaController extends Controller
{

    //VISTA CLIENTES
    public function index(Request $request)
    {
        $excludeUsers = $request->get('exclude_users', false);

        $query = Persona::selectRaw("
        id_persona, 
        CONCAT(nombre, ' ', papellido, ' ', COALESCE(sapellido, '')) AS NOMBRE,
        carnet AS CARNET,
        celular AS CELULAR,
        EXISTS(SELECT 1 FROM users WHERE users.id = personas.id_persona AND users.deleted_at IS NULL) AS has_user
    ")->whereNull('personas.deleted_at');

        if ($excludeUsers) {
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

    //EDITAR CLIENTES:
    public function editCliente(Persona $persona)
    {
        return view('pages.personas.clientes.editarPersona', compact('persona'));
    }

    public function updateCliente(UpdateRequestCliente $request, Persona $persona)
    {
        $persona->update($request->validated()); // Update the instance with validated data

        return redirect()->route('personas.clientes.vistaClientes')->with('success', 'Persona actualizada correctamente.');
    }

    public function checkCarnet(Request $request)
    {
        $exists = Persona::where('carnet', $request->carnet)
            ->where('id_persona', '<>', $request->id_persona) // Excluir la persona actual
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkCelular(Request $request)
    {
        $exists = Persona::where('celular', $request->celular)
            ->where('id_persona', '<>', $request->id_persona) // Excluir la persona actual
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function destroy($id)
    {
        $persona = Persona::find($id);

        if ($persona) {
            // Check if the persona has a related user, movimiento or contacto record
            $hasUser = User::where('id', $id)->exists(); // Check if the persona has a related user record
            $hasMovimiento = Movimiento::where(function ($query) use ($id) {
                $query->where('id_cliente', $id)
                    ->orWhere('id_proveedor', $id)
                    ->orWhere('id_operador', $id);
            })->exists();
            $hasContacto = Contacto::where('id_persona', $id)->exists(); // Check if the persona has a related contacto record

            //If any of the conditions above are true prevent the deletion of the record
            $errorMessages = [];

            if ($hasUser) {
                $errorMessages[] = 'tiene un usuario asociado';
            }

            if ($hasMovimiento) {
                $errorMessages[] = 'tiene movimientos asociados';
            }

            if ($hasContacto) {
                $errorMessages[] = 'tiene empresas asociadas';
            }

            if (!empty($errorMessages)) {
                $errorMessage = 'No se puede eliminar la persona porque ' . implode(', ', $errorMessages) . '.';
                return redirect()->route('personas.clientes.vistaClientes')->with('error', $errorMessage);
            } else {
                $persona->delete(); // Soft delete
            }
            return redirect()->route('personas.clientes.vistaClientes')->with('success', 'Persona eliminada correctamente.');
        } else {
            return redirect()->route('personas.clientes.vistaClientes')->with('error', 'Persona no encontrada.');
        }
    }
}
