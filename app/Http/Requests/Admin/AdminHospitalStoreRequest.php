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
            'address_id' => 'nullable|exists:addresses,id',
            'zip_code' => 'required_without:address_id|string|size:8',
            'street' => 'required_without:address_id|string|min:5|max:100',
            'neighbourhood' => 'required_without:address_id|string|min:5|max:100',
            'state' => 'required_without:address_id|string|size:2',
            'city' => 'required_without:address_id|string|min:5|max:100',
            'house_number' => 'required_without:address_id|string|min:1|max:100',
            'complement' => 'nullable|string|min:3|max:100',
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
            'required_if' => 'O campo :attribute é obrigatório quando a :other é do tipo Usuário',
            'required_without' => 'O campo :attribute é obrigatório quando o campo address_id não está presente'
        ];
    }

    public function prepareForValidation(): void
    {
        $sanitizedDocument = str_replace(['.', '-', '/'], '', $this->company_document);
        $status = $this->status && $this->status === 'true' ? true : false;

        if (isset($this->status)) {
            if (!empty($this->zip_code)) {
                $zipCodeWithoutHyphen = str_replace('-', '', $this->zip_code);
                $this->merge([
                    'company_document' => $sanitizedDocument,
                    'status' => $status,
                    'zip_code' => $zipCodeWithoutHyphen
                ]);
            }
            else {
                $this->merge([
                    'company_document' => $sanitizedDocument,
                    'status' => $status,
                ]);
            }
        }
        else {
            if (!empty($this->zip_code)) {
                $zipCodeWithoutHyphen = str_replace('-', '', $this->zip_code);
                $this->merge([
                    'company_document' => $sanitizedDocument,
                    'zip_code' => $zipCodeWithoutHyphen
                ]);
            } else {
                $this->merge([
                    'company_document' => $sanitizedDocument
                ]);
            }
        }
    }
}
