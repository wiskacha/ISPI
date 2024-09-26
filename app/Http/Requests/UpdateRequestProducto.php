<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestProducto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this if you have authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('producto'); // Get the product ID from the route

        return [
            'codigo' => 'required|string|max:100|unique:productos,codigo,' . $id . ',id_producto', // Ignore current product
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $id . ',id_producto',
            'precio' => 'required|numeric',
            'presentacion' => 'nullable|string|max:200',
            'unidad' => 'required|string|max:100',
            'id_empresa' => 'nullable|integer|exists:empresas,id_empresa',
            'tags' => 'nullable|string',
        ];
    }
}
