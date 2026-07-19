<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstallationTypeResource;
use App\Services\InstallationTypeService;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallationTypesController extends Controller
{
    private InstallationTypeService $installationService;

    /**
     * @param InstallationTypeService $installationService
     */
    public function __construct(InstallationTypeService $installationService)
    {
        $this->installationService = $installationService;
    }

    /**
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $installationTypes = $this->installationService->getAll();

        return InstallationTypeResource::collection($installationTypes);
    }
}
