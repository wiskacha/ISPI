<?php

namespace App\Http\Controllers;

use App\Models\Almacene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlmaceneController extends Controller
{
    // Mostrar lista de almacenes
    public function index()
    {
        $almacenes = Almacene::all();
        return view('pages.almacenes.vistaAlmacenes', compact('almacenes'));
    }

    // Página para registrar almacen
    public function register()
    {
        return view('pages.almacenes.registroAlmacene');
    }

    // Registrar almacen en la base de datos
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:almacenes', // Validación del nombre
                'unique:almacenes,nombre', // Validación de la columna 'nombre' en la tabla 'almacenes'
            ],
        ], [
            'nombre.required' => 'El nombre del almacen es requerido.',
            'nombre.string' => 'El nombre del almacen debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del almacen debe tener como máximo :100 caracteres.',
            'nombre.unique' => 'El nombre del almacen ya existe en el sistema. Por favor, ingrese un nombre diferente.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Retornar errores de validación
        }

        // Crear nuevo almacen
        Almacene::create($request->all());

        return redirect()->route('almacenes.vista')->with('success', 'Almacen registrado exitosamente.'); // Redirigir con mensaje de éxito
    }

    // Mostrar formulario para editar almacen
    public function edit($id_almacen)
    {
        $almacene = Almacene::findOrFail($id_almacen); // Use findOrFail to fetch the almacen by id_almacen
        return view('pages.almacenes.editarAlmacene', compact('almacene'));
    }

    // Actualizar almacen en la base de datos
    public function update(Request $request, $id_almacen)
    {
        // Fetch the almacen by its primary key
        $almacene = Almacene::findOrFail($id_almacen);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:almacenes,nombre,' . $almacene->id_almacen . ',id_almacen', // Use id_almacen as the primary key
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the almacen
        $almacene->update($request->all());

        return redirect()->route('almacenes.vista')->with('success', 'Almacen actualizado exitosamente.');
    }

    // Eliminar almacen de la base de datos
    public function destroy($id)
    {
        $almacene = Almacene::findOrFail($id); // Use findOrFail to fetch the almacen by id

        //Comprobar relaciones con Movimientos
        $hasMovimientos = $almacene->movimientos()->exists();
        if ($hasMovimientos) {
            return redirect()->route('almacenes.vista')->with('error', 'No se puede eliminar el almacen porque tiene movimientos asociados.');
        } else {
            $almacene->delete(); // Delete the almacen
            return redirect()->route('almacenes.vista')->with('success', 'Almacen eliminado exitosamente.');
        }
    }
}
