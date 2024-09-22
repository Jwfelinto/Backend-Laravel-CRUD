<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="ToolResource",
 *     description="Tool resource",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID do tool"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nome do tool"
 *     )
 * )
 */
class ToolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($request->routeIs(
            'project.show',
            'project.store',
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
