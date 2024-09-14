<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstallationTypeResource;
use App\Services\InstallationTypeService;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Installation Types",
 *     description="API Endpoints for Installation Types"
 * )
 * @OA\PathItem(
 *     path="/api/installation-types"
 * )
 */
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
     * @OA\Get(
     *     path="/api/installation-types",
     *     tags={"Installation Types"},
     *     summary="List all installation types",
     *     description="Return a list of all installation types",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/InstallationTypeResource"))
     *     )
     * )
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $installationTypes = $this->installationService->getAll();

        return InstallationTypeResource::collection($installationTypes);
    }
}
