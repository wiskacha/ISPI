<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestUsuario extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'papellido' => 'required|string|max:100',
            'sapellido' => 'nullable|string|max:100',
            'carnet' => 'required|string|unique:personas,carnet|max:100',
            'celular' => 'nullable|string|max:11',
            'nick' => 'required|string|unique:users,nick|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
    

    public function messages(): array
    {
        return [
            // Error messages for persona and user fields
            'nombre.required' => 'El nombre es requerido.',
            'nick.required' => 'El nick es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            // ... other validation messages
        ];
    }
}
