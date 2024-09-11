<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectController extends Controller
{
    private const FILTERS = [
        'client',
        'location',
        'installation_type',
        'tools',
        'date',
        'start_date',
        'end_date',
    ];

    private ProjectService $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $projects = $this->projectService->getProjects($filters);

        return ProjectResource::collection($projects);
    }

    public function show(Project $project): JsonResource
    {
        return new ProjectResource($project);
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        $this->projectService->createProject($request->validated());

        return response()->json([
            'message' => 'Project successfully created!'
        ]);
    }

    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $result = $this->projectService->updateProject($request->validated(), $project);

        return response()->json([
            'message' => 'Project successfully updated!',
            'data' => new ProjectResource($result)
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project successfully deleted!'
        ]);
    }
}
