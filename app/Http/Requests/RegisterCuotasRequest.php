<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterCuotasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'id_movimiento' => ['required', Rule::exists('movimientos', 'id_movimiento')],
            'tipo_pago' => ['required', 'in:CONTADO,CRÉDITO'],
            'descuento' => ['nullable', 'numeric'],
            'aditivo' => ['nullable', 'numeric'],
            'cantidad_cuotas' => ['required_if:tipo_pago,CRÉDITO','nullable' ,'integer', 'min:1'],
            'primer_pago' => ['required_if:tipo_pago,CRÉDITO', 'nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_movimiento.exists' => 'El movimiento no existe.',
            'tipo_pago.in' => 'El tipo de pago debe ser CONTADO o CRÉDITO.',
            'cantidad_cuotas.required_if' => 'La cantidad de cuotas es requerida para el tipo de pago CRÉDITO.',
            'cantidad_cuotas.integer' => 'La cantidad de cuotas debe ser un número entero.',
            'cantidad_cuotas.min' => 'La cantidad de cuotas debe ser mayor o igual a 1.',
            'primer_pago.required_if' => 'El primer pago es requerido para el tipo de pago CRÉDITO.',
            'primer_pago.numeric' => 'El primer pago debe ser un número.',
            'primer_pago.min' => 'El primer pago debe ser mayor o igual a 0.',
        ];
    }
}

