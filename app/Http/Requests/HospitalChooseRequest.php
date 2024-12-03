<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalChooseRequest extends FormRequest
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
            'hospitals' => 'required|array',
            'hospitals.*.id' => 'required|string|exists:hospitals,id'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório',
            'string' => 'Este campo deve ser um texto',
            'array' => 'Este campo deve ser um vetor de dados',
            'hospitals.*.id.exists' => 'Valor inválido ou inexistente'
        ];
    }
}
