<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateClientRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            Rule::unique('clients')->ignore($this->id),
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string',
            Rule::unique('clients')->ignore($this->id),
        ];
    }
}
