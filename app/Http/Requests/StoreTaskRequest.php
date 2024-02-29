<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'description' => 'nullable|string',
            'company_id' => 'required|numeric|min:1|exists:companies,id',
            'user_id' => 'required|numeric|min:1|exists:users,id'
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
            'name.required' => 'El :atribute es requerido.',
            'name.string' => 'El :atribute debe de ser una cadena de texto.',
            'name.max' => 'El :atribute es debe contener máximo 255 .',
            'description.string' => 'El :atribute debe de ser una cadena de texto.',
            'company_id.required' => 'El :atribute es requerido.',
            'company_id.numeric' => 'El :atribute debe de ser numerico.',
            'company_id.min' => 'El :atribute debe de ser minimo de 1.',
            'company_id.exists' => 'El :atribute debe de existir.',
            'user_id.required' => 'El :atribute es requerido.',
            'user_id.numeric' => 'El :atribute debe de ser numerico.',
            'user_id.min' => 'El :atribute debe de ser minimo de 1.',
            'user_id.exists' => 'El :atribute debe de existir.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'company_id' => 'campo identificador de compañia',
            'user_id' => 'campo identificador de usuario',
        ];
    }
}
