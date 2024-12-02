<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'zip_code' => 'sometimes|string|size:8',
            'street' => 'sometimes|string|min:5|max:100',
            'neighbourhood' => 'sometimes|string|min:5|max:100',
            'state' => 'sometimes|string|size:2',
            'city' => 'sometimes|string|min:5|max:100',
            'house_number' => 'sometimes|string|min:1|max:100',
            'complement' => 'sometimes|string|min:3|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'size' => 'Este campo deve conter exatamente :size caracteres',
        ];
    }

    public function prepareForValidation()
    {
        if (!empty($this->zip_code)) {
            $zipCodeWithoutHyphen = str_replace('-', '', $this->zip_code);
    
            $this->merge([
                'zip_code' => $zipCodeWithoutHyphen
            ]);
        }
    }
}
