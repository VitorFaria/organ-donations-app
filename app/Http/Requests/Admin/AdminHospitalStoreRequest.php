<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminHospitalStoreRequest extends FormRequest
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
            'address_id' => 'required|exists:addresses,id',
            'name' => 'required|string|min:5|max:100',
            'phone' => 'required|string|max:11',
            'email' => 'required|email',
            'company_document' => 'required|string|size:14|unique:hospitals,company_document',
            'status' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return  [
            'required' => 'Este campo é obrigatório',
            'email' => 'Este campo deve ser um endereço de email válido',
            'string' => 'Este campo deve ser um texto',
            'min' => 'Este campo deve conter no mínimo :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres',
            'exists' => 'Valor informado inválido ou inexistente',
            'unique' => 'Documento já utilizado',
            'size' => 'Este campo deve conter exatamente :size caracteres',
            'boolean' => 'Este campo deve ser verdadeiro ou falso',
        ];
    }

    public function prepareForValidation(): void
    {
        $sanitizedDocument = str_replace(['.', '-', '/'], '', $this->company_document);

        $fieldsToMerge = [
            'company_document' => $sanitizedDocument,
            'status' => $this->status && $this->status === 'true' ? true : false,
        ];
        $this->merge([
            isset($this->status) ? $fieldsToMerge : $fieldsToMerge['company_document'],
        ]);
    }
}
