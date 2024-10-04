<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRecinto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'unique:recintos,nombre,' . $this->route('id_recinto') . ',id_recinto',
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:150',
            ],
            'telefono' => [
                'nullable',
                'numeric',
                'digits_between:7,8',
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del recinto es requerido.',
            'nombre.string' => 'El nombre del recinto debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del recinto debe tener como máximo :max caracteres.',
            'nombre.unique' => 'El nombre del recinto ya existe en el sistema. Por favor, ingrese un nombre diferente.',
            'direccion.string' => 'La dirección del recinto debe ser una cadena de texto.',
            'direccion.max' => 'La dirección del recinto debe tener como máximo :max caracteres.',
            'telefono.numeric' => 'El tlf. del recinto debe ser un número.',
            'telefono.digits_between' => 'El tlf. del recinto debe tener entre 7 y 8 dígitos.',
        ];
    }
}
