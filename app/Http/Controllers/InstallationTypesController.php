<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstallationTypeResource;
use App\Services\InstallationTypeService;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="InstallationType",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
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
     *     tags={"InstallationTypes"},
     *     summary="List all installation types",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/InstallationType"))
     *     )
     * )
     */
    public function index(): JsonResource
    {
        $installationTypes = $this->installationService->getAll();

        return InstallationTypeResource::collection($installationTypes);
    }
}
