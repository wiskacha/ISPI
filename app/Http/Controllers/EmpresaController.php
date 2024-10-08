<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    // Mostrar lista de empresas
    public function index()
    {
        $empresas = Empresa::all(); // Obtener todas las empresas
        return view('pages.empresas.vistaEmpresas', compact('empresas')); // Pasar datos a la vista
    }

    // Página para registrar empresa
    public function register()
    {
        return view('pages.empresas.registroEmpresa'); // Retornar vista para registrar empresa
    }

    // Registrar empresa en la base de datos
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:empresas', // Validación del nombre
                'unique:empresas,nombre', // Validación de la columna 'nombre' en la tabla 'empresas'
            ],
        ], [
            'nombre.required' => 'El nombre de la empresa es requerido.',
            'nombre.string' => 'El nombre de la empresa debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la empresa debe tener como máximo :100 caracteres.',
            'nombre.unique' => 'El nombre de la empresa ya existe en el sistema. Por favor, ingrese un nombre diferente.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Retornar errores de validación
        }

        // Crear nueva empresa
        Empresa::create($request->all());

        return redirect()->route('empresas.vista')->with('success', 'Empresa registrada exitosamente.'); // Redirigir con mensaje de éxito
    }

    // Mostrar formulario para editar empresa
    public function edit($id_empresa)
    {
        $empresa = Empresa::findOrFail($id_empresa); // Use findOrFail to fetch the empresa by id_empresa
        return view('pages.empresas.editarEmpresa', compact('empresa'));
    }

    public function update(Request $request, $id_empresa)
    {
        // Fetch the empresa by its primary key
        $empresa = Empresa::findOrFail($id_empresa);

        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:empresas,nombre,' . $empresa->id_empresa . ',id_empresa', // Use id_empresa as the primary key
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Redirect back with errors
        }

        // Update the empresa
        $empresa->update($request->all());

        return redirect()->route('empresas.vista')->with('success', 'Empresa actualizada exitosamente.'); // Redirect with success message
    }



    // Eliminar empresa de la base de datos
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id); // Buscar la empresa por ID

        // Verificar si la empresa tiene registros asociados en productos o contactos
        $hasProductos = $empresa->productos()->exists();
        $hasContactos = $empresa->contactos()->exists();
        $errorMessages = [];
        if ($hasProductos) {
            $errorMessages[] = 'tiene productos asociados';
        }
        if ($hasContactos) {
            $errorMessages[] = 'tiene contactos asociados';
        }

        if (!empty($errorMessages)) {
            $errorMessage = 'No se puede eliminar la empresa porque ' . implode(', ', $errorMessages) . '.';
            return redirect()->route('empresas.vista')->withErrors($errorMessage); // Redirigir con mensajes de error
        } else {

            $empresa->delete(); // Eliminar empresa
            return redirect()->route('empresas.vista')->with('success', 'Empresa eliminada exitosamente.'); // Redirigir con mensaje de éxito
        }
    }
}
