<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="LocationResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string")
 * )
 */
class LocationController extends Controller
{
    private LocationService $locationService;

    /**
     * @param LocationService $locationService
     */
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * @OA\Get(
     *     path="/api/locations",
     *     tags={"Locations"},
     *     summary="List all locations",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LocationResource"))
     *     )
     * )
     */
    public function index(): JsonResource
    {
        $locations = $this->locationService->getAll();

        return LocationResource::collection($locations);
    }
}
