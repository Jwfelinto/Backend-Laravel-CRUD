<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ClientRequest",
 *     required={"name", "email", "phone", "cpf_cnpj"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="123456789"),
 *     @OA\Property(property="cpf_cnpj", type="string", example="123.456.789-00")
 * )
 */
class ClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->rulesForStore();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->rulesForUpdate();
        }

        return [];
    }

    /**
     * @return string[]
     */
    public function rulesForStore(): array
    {
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
        $clientId = $this->route('client')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:clients,email,' . $clientId,
            'phone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string|unique:clients,cpf_cnpj,' . $clientId,
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
