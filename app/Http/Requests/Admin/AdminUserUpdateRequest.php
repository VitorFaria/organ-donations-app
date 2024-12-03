<?php

namespace App\Http\Requests\Admin;

use App\Enums\PatientType;
use App\Enums\Role;
use App\Rules\BloodTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AdminUserUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|min:1|max:100',
            'email' => [
                'sometimes', 
                'email',
                Rule::unique('users')->ignore($this->id, 'id')
            ],
            'role' => [
                'sometimes',
                new Enum(Role::class)
            ],
            'password' => 'sometimes|string|min:8',
            'patient_type' => [
                'required_if:role,user',
                new Enum(PatientType::class)
            ],
            'blood_type' => [
                'required_if:role,user',
                new BloodTypeRule()
            ],
            'organs' => 'required_if:role,user|array',
            'organs.*.id' => 'required_if:role,user|string|exists:organs,id'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório',
            'email' => 'Este campo deve ser um endereço de email válido',
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'unique' => 'Valor já existente', 
            'role.Illuminate\Validation\Rules\Enum' => 'Role inválida para cadastro',
            'type.Illuminate\Validation\Rules\Enum' => 'Tipo de paciente inválida para cadastro',
            'blood_type.Illuminate\Validation\Rules\Enum' => 'Tipo sanguíneo inválido para cadastro',
            'array' => 'Este campo deve ser um vetor de dados',
            'organs.*.id.exists' => 'Valor inválido ou inexistente',
            'required_if' => 'O campo :attribute é obrigatório quando a :other é do tipo Usuário'
        ];
    }
}
