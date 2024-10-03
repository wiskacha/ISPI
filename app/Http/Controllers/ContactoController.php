<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Empresa;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RegisterRequestContactoE;


class ContactoController extends Controller
{
    // Index to list all contactos
    public function index()
    {
        // Get unique personas with their associated empresas
        $contactos = Contacto::with(['persona', 'empresa'])
            ->get()
            ->groupBy('id_persona');

        return view('pages.contactos.vistaContactos', compact('contactos'));
    }



    // Register view to create a new Persona and associate it with an existing Empresa
    public function registerpage()
    {
        // Retrieve all existing empresas to choose from
        $empresas = Empresa::all(); // SoftDeletes already excludes "deleted" records
        return view('pages.contactos.registroContacto', compact('empresas'));
    }

    public function registerpageE()
    {
        // Get all personas and empresas without worrying about deleted records
        $personas = Persona::all();
        $empresas = Empresa::all();
        return view('pages.contactos.create.existingContacto', compact('personas', 'empresas'));
    }

    public function registerpageF()
    {
        // Get all personas and empresas without worrying about deleted records
        $personas = Persona::all();
        $empresas = Empresa::all();
        return view('pages.contactos.create.freshContacto', compact('personas', 'empresas'));
    }

    // Register a new Persona and associate with an existing Empresa
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            // Create a new Persona
            $personaData = $request->only('nombre', 'papellido', 'sapellido', 'carnet', 'celular');
            $persona = Persona::create($personaData);
            // Ensure that the persona was created successfully
            if (!$persona->id_persona) {
                throw new \Exception('Error creating Persona.');
            }
            // Create a new Contacto associating the persona with an existing empresa
            Contacto::create([
                'id_persona' => $persona->id_persona,
                'id_empresa' => $request->id_empresa,
            ]);

            DB::commit();
            return redirect()->route('contactos.vistaContactos')->with('success', 'Contacto creado correctamente.');
        } catch (\Exception $e) {
            log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al registrar el contacto.'])->withInput();
        }
    }

    // Associate an existing Persona with an existing Empresa
    public function registerE(RegisterRequestContactoE $request)
    {
        DB::beginTransaction();

        try {

            // Ensure that the relation between Persona and Empresa does not already exist
            $existingContacto = Contacto::where('id_persona', $request->id_persona)
                ->where('id_empresa', $request->id_empresa)
                ->first();

            if ($existingContacto) {
                return redirect()->back()->withErrors(['Este contacto ya existe.'])->withInput();
            }
            // Create the Contacto
            Contacto::create([
                'id_persona' => $request->id_persona,
                'id_empresa' => $request->id_empresa,
            ]);

            DB::commit();
            return redirect()->route('contactos.vistaContactos')->with('success', 'Contacto asociado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al asociar el contacto.'])->withInput();
        }
    }

    // Soft delete contacto
    public function destroy($id_persona, $id_empresa)
    {
        $contacto = Contacto::where('id_persona', $id_persona)
            ->where('id_empresa', $id_empresa)
            ->delete();

        return redirect()->back()->with('success', 'Contacto eliminado correctamente.');
    }


    // Edit contacto
    public function edit(Persona $persona)
    {
        $contactos = Contacto::where('id_persona', $persona->id_persona)
            ->get();
        return view('pages.contactos.editarContacto', compact('persona', 'contactos'));
    }


    // Update contacto
    public function update(Request $request, $id_persona, $id_empresa)
    {
        $contacto = Contacto::where('id_persona', $id_persona)
            ->where('id_empresa', $id_empresa)
            ->first();

        if ($contacto) {
            $contacto->update([
                'id_empresa' => $request->id_empresa, // Allow changing the associated empresa
            ]);
            return redirect()->route('contactos.vistaContactos')->with('success', 'Contacto actualizado correctamente.');
        } else {
            return redirect()->route('contactos.vistaContactos')->with('error', 'Contacto no encontrado.');
        }
    }
}
