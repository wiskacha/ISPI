<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        // dd($this->all());
        return [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'unidad' => 'required|string|max:255',
            'presentacion' => 'required|string|max:255',
            'id_empresa' =>'required|exists:empresas,id_empresa',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'documentos.*' => 'nullable|file|mimes:pdf|max:5124',
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
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',

            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.max' => 'El código no debe exceder los 255 caracteres.',

            'precio.required' => 'El campo precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',

            'unidad.required' => 'El campo unidad es obligatorio.',
            'unidad.string' => 'La unidad debe ser una cadena de texto.',
            'unidad.max' => 'La unidad no debe exceder los 255 caracteres.',

            'presentacion.required' => 'El campo presentación es obligatorio.',
            'presentacion.string' => 'La presentación debe ser una cadena de texto.',
            'presentacion.max' => 'La presentación no debe exceder los 255 caracteres.',

            'tags.string' => 'Los tags deben ser una cadena de texto.',

            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'image.max' => 'La imagen no debe exceder los 2MB.',

            'imagenes.*.image' => 'Cada archivo debe ser una imagen.',
            'imagenes.*.mimes' => 'Cada imagen debe ser de tipo: jpeg, png, jpg.',
            'imagenes.*.max' => 'Cada imagen no debe exceder los 2MB.',

            'documentos.*.file' => 'Cada archivo debe ser un archivo.',
            'documentos.*.mimes' => 'Cada documento debe ser de tipo: pdf.',
            'documentos.*.max' => 'Cada documento no debe exceder los 5MB.',
        ];
    }
}
