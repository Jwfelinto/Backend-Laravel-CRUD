<?php

namespace App\Http\Requests;

class StoreUserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:10',
        ];
    }
}
