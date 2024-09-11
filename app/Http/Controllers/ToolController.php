<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToolResource;
use App\Services\ToolService;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $tools = $this->toolService->getAll();

        return ToolResource::collection($tools);
    }
}
