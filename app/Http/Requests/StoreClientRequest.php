<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreClientRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:clients,email',
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string|unique:clients,cpf_cnpj',
        ];
    }
}
