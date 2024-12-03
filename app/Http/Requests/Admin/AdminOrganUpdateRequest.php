<?php

namespace App\Http\Requests\Admin;

use App\Enums\OrganType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AdminOrganUpdateRequest extends FormRequest
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
            'name' => [
                'sometimes', 
                'string',
                'min:3',
                'max:100',
                Rule::unique('organs')->ignore($this->id, 'id')
            ],
            'organ_type' => [
                'sometimes',
                new Enum(OrganType::class)
            ],
            'slug' => 'sometimes|string|min:3|max:200'
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'unique' => 'Nome já existente', 
            'organ_type.Illuminate\Validation\Rules\Enum' => 'Tipo de orgão inválido',
        ];
    }
}
