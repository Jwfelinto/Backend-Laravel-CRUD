<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return $this->rulesForUpdate();
        }

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:clients,email',
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string|unique:clients,cpf_cnpj',
        ];
    }

    /**
     * @return string[]
     */
    public function rulesForUpdate(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email', Rule::unique('clients')->ignore($this->id),
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string', Rule::unique('clients')->ignore($this->id),
        ];
    }


    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
