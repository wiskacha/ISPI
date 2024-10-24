<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recinto;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateRequestRecinto;

class RecintoController extends Controller
{
    // Mostrar lista de recintos
    public function index()
    {
        $recintos = Recinto::all();
        return view('pages.recintos.vistaRecintos', compact('recintos'));
    }

    // Página para registrar recinto
    public function register()
    {
        return view('pages.recintos.registroRecinto');
    }

    // Página para editar recinto
    public function edit($id_recinto)
    {
        $recinto = Recinto::find($id_recinto);
        return view('pages.recintos.editarRecinto', compact('recinto'));
    }

    // Eliminar un recinto
    public function destroy($id_recinto)
    {
        $recinto = Recinto::find($id_recinto);
        //Comprobar relacion con tabla Movimientos
        $hasMovimientos = Movimiento::where('id_recinto', $id_recinto)->exists();
        //En caso de te nerla prevenir el delete
        if ($hasMovimientos) {
            return redirect()->route('recintos.vista')->with('error', 'No se puede eliminar el recinto porque tiene movimientos asociados.');
        }
        $recinto->delete();
        return redirect()->route('recintos.vista')->with('success', 'Recinto: ' . $recinto->nombre . ' eliminado exitosamente.');
    }

    // Registrar un nuevo recinto
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:recintos', // Validación del nombre
                'unique:recintos,nombre', // Validación de la columna 'nombre' en la tabla 'recintos'
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:150',
            ],
            'telefono' => [
                'nullable',
                'numeric',
                'digits_between:7,8', // Acepta entre 8 y 11 dígitos
            ],
        ], [
            'nombre.required' => 'El nombre del recinto es requerido.',
            'nombre.string' => 'El nombre del recinto debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del recinto debe tener como máximo :max caracteres.',
            'nombre.unique' => 'El nombre del recinto ya existe en el sistema. Por favor, ingrese un nombre diferente.',
            'direccion.string' => 'La dirección del recinto debe ser una cadena de texto.',
            'direccion.max' => 'La dirección del recinto debe tener como máximo :max caracteres.',
            'telefono.numeric' => 'El tlf. del recinto debe ser un número.',
            'telefono.digits_between' => 'El tlf. del recinto debe tener entre 7 y 8 dígitos.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Retornar errores de validación
        }

        // Crear nuevo recinto
        Recinto::create($request->all()); // Ajusta los campos según tu modelo

        return redirect()->route('recintos.vista')->with('success', 'Recinto registrado exitosamente.'); // Redirigir con mensaje de éxito
    }

    // Actualizar la información de un recinto
    public function update(UpdateRequestRecinto $request, $id_recinto)
    {
        $recinto = Recinto::findorFail($id_recinto);
        $recinto->update($request->all());
        return redirect()->route('recintos.vista')->with('success', 'Recinto actualizado exitosamente.'); // Redirigir con mensaje de éxito
    }
}
