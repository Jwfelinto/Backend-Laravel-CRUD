<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs('process.index')) {
            return $this->toArrayCollection($request);
        }

        return [
            'id' => $this->id,
            'client' => [
                'id' => $this->client->id,
                'name' => $this->client->name,
            ],
            'location' => $this->location->uf,
            'installation_type' => $this->installationType->name,
            'tools' => $this->tools->pluck(['name', 'quantity']),
        ];
    }

    private function toArrayCollection(Request $request): array
    {
        return [
            'id' => $this->id,
            'installation_type' => $this->installationType->name,
            'client' => $this->client->name
        ];
    }
}
