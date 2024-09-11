<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'location_id' => 'required|exists:locations,id',
            'installation_type_id' => 'required|exists:installation_types,id',
            'tools' => 'required|array',
            'tools.*.id' => 'required|exists:tools,id',
            'tools.*.quantity' => 'required|integer',

        ];
    }
}
