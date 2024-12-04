<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'zip_code' => 'required|string|size:8',
            'street' => 'required|string|min:5|max:100',
            'neighbourhood' => 'required|string|min:5|max:100',
            'state' => 'required|string|size:2',
            'city' => 'required|string|min:5|max:100',
            'house_number' => 'required|string|min:1|max:100',
            'complement' => 'nullable|string|min:3|max:100',
            'user_id' => 'nullable|string|exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório',
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'size' => 'Este campo deve conter exatamente :size caracteres',
            'exists' => 'Valor inválido ou inexistente'
        ];
    }

    public function prepareForValidation()
    {
        $zipCodeWithoutHyphen = str_replace('-', '', $this->zip_code);

        $this->merge([
            'zip_code' => $zipCodeWithoutHyphen
        ]);
    }
}
