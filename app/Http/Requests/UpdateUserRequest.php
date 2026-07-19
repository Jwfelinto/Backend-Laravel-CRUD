<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            Rule::unique('users')->ignore($this->id),
            'password' => 'required|string|min:10',
        ];
    }
}
