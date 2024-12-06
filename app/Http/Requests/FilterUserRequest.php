<?php

namespace App\Http\Requests;

use App\Enums\PatientType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FilterUserRequest extends FormRequest
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
            'type' => [
                'nullable',
                'string',
                new Enum(PatientType::class),
            ],

            'email' => 'nullable|string|min:3|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'type.Illuminate\Validation\Rules\Enum' => 'Tipo de paciente inválido'
        ];
    }
}
