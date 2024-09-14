<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToolResource;
use App\Services\ToolService;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Tools",
 *     description="API Endpoints for Tools"
 * )
 * @OA\PathItem(
 *     path="/api/tools"
 * )
 */
class ToolController extends Controller
{
    private ToolService $toolService;

    /**
     * @param ToolService $toolService
     */
    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    /**
     * @OA\Get(
     *     path="/api/tools",
     *     tags={"Tools"},
     *     summary="List all tools",
     *     description="Return a list of all tools",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ToolResource"))
     *     )
     * )
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $tools = $this->toolService->getAll();

        return ToolResource::collection($tools);
    }
}
