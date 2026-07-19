<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'email' => 'required|email',
            Rule::unique('clients')->ignore($this->id),
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string',
            Rule::unique('clients')->ignore($this->id),
        ];
    }
}
