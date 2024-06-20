<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                'unique:personas,carnet',
                'regex:/^\d{7}$/'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'nick' => [
                'required',
                'unique:users,nick',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/^[\S]+$/'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios, sin números ni caracteres especiales, y no debe empezar ni terminar con un espacio.',
            'papellido.required' => 'El primer apellido es requerido.',
            'papellido.regex' => 'El primer apellido solo puede contener letras y espacios, sin números ni caracteres especiales, y no debe empezar ni terminar con un espacio.',
            'carnet.required' => 'El carnet es requerido.',
            'carnet.unique' => 'El carnet ya está en uso.',
            'carnet.regex' => 'El carnet debe contener exactamente 7 dígitos y no puede tener letras ni espacios.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'nick.required' => 'El nick es requerido.',
            'nick.unique' => 'El nick ya está en uso.',
            'nick.regex' => 'El nick solo puede contener letras, números y guiones bajos, sin espacios.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña no puede contener espacios.',
            'password_confirmation.required' => 'La confirmación de la contraseña es requerida.',
            'password_confirmation.same' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
