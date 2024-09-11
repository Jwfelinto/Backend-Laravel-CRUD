<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $locations = $this->locationService->getAll();

        return LocationResource::collection($locations);
    }
}
