<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ClientResource",
 *     required={"id", "name", "email", "phone", "cpf_cnpj"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="123456789"),
 *     @OA\Property(property="cpf_cnpj", type="string", example="123.456.789-00"),
 *     @OA\Property(property="projects", type="array", @OA\Items(ref="#/components/schemas/ProjectResource"))
 * )
 */

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs('client.index')) {
            return $this->toArrayCollection($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cpf_cnpj' => $this->cpf_cnpj,
            'projects' => ProjectResource::collection($this->projects)
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    private function toArrayCollection(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
