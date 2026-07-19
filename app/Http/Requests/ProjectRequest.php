<?php

namespace App\Http\Requests;

class ProjectRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'location_id' => 'required|exists:locations,id',
            'installation_type_id' => 'required|exists:installation_types,id',
            'tools' => 'required|array',
            'tools.*.id' => 'required|exists:tools,id',
            'tools.*.quantity' => 'required|integer|min:1',
        ];
    }
}
