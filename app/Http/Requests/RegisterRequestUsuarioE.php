<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use Illuminate\Validation\Rule;

class RegisterRequestUsuarioE extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nick' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'nick'),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required', // Changed from nullable to required
                'string',
                'min:8',
                'confirmed', // Assumes there is a password_confirmation field
            ],
        ];
    }

    public function messages()
    {
        return [
            'nick.required' => 'El nick es requerido',
            'nick.string' => 'El nick debe ser una cadena de caracteres',
            'nick.max' => 'El nick debe ser menor a 255 caracteres',
            'nick.unique' => 'El nick ya existe en la base de datos',

            'email.required' => 'El correo electrónico es requerido',
            'email.string' => 'El correo electrónico debe ser una cadena de caracteres',
            'email.email' => 'El correo electrónico debe ser un correo electrónico valido',
            'email.max' => 'El correo electrónico debe ser menor a 255 caracteres',
            'email.unique' => 'El correo electrónico ya existe en la base de datos',

            'password.required' => 'La contrase a es requerida',
            'password.string' => 'La contrase a debe ser una cadena de caracteres',
            'password.min' => 'La contrase a debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contrase as no coinciden',

        ];
    }
}
