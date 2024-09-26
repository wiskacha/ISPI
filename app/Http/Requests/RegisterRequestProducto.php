<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestProducto extends FormRequest
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
        return [
            'codigo' => 'required|string|max:100|unique:productos', // Uniqueness check
            'nombre' => 'required|string|max:100|unique:productos',
            'precio' => 'required|numeric',
            'presentacion' => 'required|string|max:200',
            'unidad' => 'required|string|max:100',
            'id_empresa' => 'nullable|integer|exists:empresas,id_empresa',
            'tags' => 'nullable|string',
        ];
    }
}
