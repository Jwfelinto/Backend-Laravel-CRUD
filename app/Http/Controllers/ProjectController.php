<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectsResource;
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

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $projects = $this->projectService->getProjects($filters);

        return ProjectsResource::collection($projects);
    }

    /**
     * @param Project $project
     * @return JsonResource
     */
    public function show(Project $project): JsonResource
    {
        return new ProjectResource($project);
    }

    /**
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());

        return response()->json([
            'message' => 'Project successfully created!',
            'data' => new ProjectResource($project)
        ], 201);
    }

    /**
     * @param ProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $result = $this->projectService->updateProject($request->validated(), $project);

        return response()->json([
            'message' => 'Project successfully updated!',
            'data' => new ProjectResource($result)
        ]);
    }

    /**
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project successfully deleted!'
        ], 204);
    }
}
