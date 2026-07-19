<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToolsResource;
use App\Services\ToolService;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolController extends Controller
{
    private ToolService $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    public function index(): JsonResource
    {
        $tools = $this->toolService->getAll();

        return ToolsResource::collection($tools);
    }
}
