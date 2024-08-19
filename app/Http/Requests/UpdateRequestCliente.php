<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestCliente extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'nombre' => [
                'required',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/'
            ],
            'papellido' => [
                'required',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/'
            ],
            'carnet' => [
                'required',
                Rule::unique('personas', 'carnet')->ignore($this->route('persona')->id_persona, 'id_persona'),
                'regex:/^\d{4,11}$/'
            ],
            'sapellido' => [
                'nullable',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/'
            ],
            'celular' => [
                'nullable',
                'regex:/^\d{8,11}$/'
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Required Fields Messages
            'nombre.required' => 'El nombre es requerido.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios, sin números ni caracteres especiales, y no debe empezar ni terminar con un espacio.',
            'papellido.required' => 'El primer apellido es requerido.',
            'papellido.regex' => 'El primer apellido solo puede contener letras y espacios, sin números ni caracteres especiales, y no debe empezar ni terminar con un espacio.',
            'carnet.required' => 'El carnet es requerido.',
            'carnet.unique' => 'El carnet ya está en uso.',
            'carnet.regex' => 'El carnet debe contener entre 4 y 11 dígitos y no puede tener letras ni espacios.',

            // Optional Fields Messages
            'sapellido.regex' => 'El segundo apellido solo puede contener letras y espacios, sin números ni caracteres especiales, y no debe empezar ni terminar con un espacio.',
            'celular.regex' => 'El celular debe contener 8 dígitos ',
        ];
    }
}
