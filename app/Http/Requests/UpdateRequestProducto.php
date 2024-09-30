<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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

        // dd('Inicialización deL ARRAY DE RULES', $this->all());

        return [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'unidad' => 'required|string|max:255',
            'presentacion' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'documentos.*' => 'nullable|file|mimes:pdf|max: 5124', // Max size 2MB
        ];
    }
}
