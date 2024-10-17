<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="password", type="string", example="password"),
 * )
 */
class UserRequest extends FormRequest
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
            'email' => 'required|email|max:100|unique:users',
            'password' => [
                'required',
                'string',
                'min:10'
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function rulesForUpdate(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email', Rule::unique('users')->ignore($this->id),
            'password' => [
                'required',
                'string',
                'min:10'
            ],
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function withValidator(Validator  $validator): void
    {
        $validator->after(function ($validator) {
            $password = $this->input('password');

            if (!preg_match('/[a-z]/', $password)) {
                $validator->errors()->add('password', 'A senha deve conter pelo menos uma letra minúscula (a-z).');
            }

            if (!preg_match('/[A-Z]/', $password)) {
                $validator->errors()->add('password', 'A senha deve conter pelo menos uma letra maiúscula (A-Z).');
            }

            if (!preg_match('/[0-9]/', $password)) {
                $validator->errors()->add('password', 'A senha deve conter pelo menos um número (0-9).');
            }

            if (!preg_match('/[!@#$%^&*]/', $password)) {
                $validator->errors()->add('password', 'A senha deve conter pelo menos um caractere especial (!@#$%^&*).');
            }
        });
    }
}
