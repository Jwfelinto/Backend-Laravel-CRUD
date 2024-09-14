<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Locations",
 *     description="API Endpoints for Locations"
 * )
 * @OA\PathItem(
 *     path="/api/locations"
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
     *     description="Return a list of all locations",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LocationResource"))
     *     )
     * )
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $locations = $this->locationService->getAll();

        return LocationResource::collection($locations);
    }
}
