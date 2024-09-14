<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs(
            'project.show',
            'project.update'
        )) {
            return $this->toArrayWithQuantity($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    /**
     * Transform the resource into an array with name and quantity.
     *
     * @return array<string, mixed>
     */
    public function toArrayWithQuantity(Request $request): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->pivot->quantity
        ];
    }
}
