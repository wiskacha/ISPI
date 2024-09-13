<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequestUsuario extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Persona fields
            'nombre' => [
                'required',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/',
            ],
            'papellido' => [
                'required',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/',
            ],
            'sapellido' => [
                'nullable',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/',
            ],
            'carnet' => [
                'required',
                'string',
                'regex:/^\d{4,11}$/',
                'unique:personas,carnet',
            ],
            'celular' => [
                'nullable',
                'string',
                'regex:/^\d{8,11}$/',
                'unique:personas,celular',
            ],
            // User fields
            'nick' => [
                'required',
                'string',
                'max:255',
                'unique:users,nick',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed', // This assumes there is a password_confirmation field
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Persona error messages
            'nombre.required' => 'El nombre es requerido.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios, sin números ni caracteres especiales.',
            'papellido.required' => 'El primer apellido es requerido.',
            'papellido.regex' => 'El primer apellido solo puede contener letras y espacios.',
            'sapellido.regex' => 'El segundo apellido solo puede contener letras y espacios.',
            'carnet.required' => 'El carnet es requerido.',
            'carnet.unique' => 'El carnet ya está en uso.',
            'carnet.regex' => 'El carnet debe contener entre 4 y 11 dígitos y no puede tener letras ni espacios.',
            'celular.regex' => 'El celular debe contener entre 8 y 11 dígitos.',
            'celular.unique' => 'El celular ya está en uso.',

            // User error messages
            'nick.required' => 'El nickname es requerido.',
            'nick.unique' => 'El nickname ya está en uso.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
