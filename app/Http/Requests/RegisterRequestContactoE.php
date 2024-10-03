<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Contacto;

class RegisterRequestContactoE extends FormRequest
{
    public function rules()
    {
        return [
            'id_persona' => 'required|exists:personas,id_persona',
            'id_empresa' => 'required|exists:empresas,id_empresa',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Contacto::where('id_persona', $this->id_persona)
                ->where('id_empresa', $this->id_empresa)
                ->exists()
            ) {
                $validator->errors()->add('contacto', 'Este contacto ya existe.');
            }
        });
    }
}
