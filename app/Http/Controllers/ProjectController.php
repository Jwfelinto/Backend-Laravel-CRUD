<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Projects",
 *     description="API Endpoints for Projects"
 * )
 * @OA\PathItem(
 *     path="/api/projects"
 * )
 * @OA\PathItem(
 *      path='/api/projects/{project}'
 *  )
 */
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

    /**
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @OA\Get(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="List all projects",
     *     description="Return a list of projects with optional filters",
     *     @OA\Parameter(
     *         name="client",
     *         in="query",
     *         description="Filter by client",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         description="Filter by location",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="installation_type",
     *         in="query",
     *         description="Filter by installation type",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tools",
     *         in="query",
     *         description="Filter by tools",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Filter by start date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Filter by end date",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProjectResource"))
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $projects = $this->projectService->getProjects($filters);

        return ProjectResource::collection($projects);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{project}",
     *     tags={"Projects"},
     *     summary="Show a project",
     *     description="Return a single project",
     *     @OA\Parameter(
     *         name="project",
     *         in="path",
     *         description="ID of the project to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProjectResource")
     *     )
     * )
     *
     * @param Project $project
     * @return JsonResource
     */
    public function show(Project $project): JsonResource
    {
        return new ProjectResource($project);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Create a new project",
     *     description="Create a new project",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project successfully created!")
     *         )
     *     )
     * )
     *
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
     * @OA\Put(
     *     path="/api/projects/{project}",
     *     tags={"Projects"},
     *     summary="Update an existing project",
     *     description="Update an existing project",
     *     @OA\Parameter(
     *         name="project",
     *         in="path",
     *         description="ID of the project to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project successfully updated!"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProjectResource")
     *         )
     *     )
     * )
     *
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
     * @OA\Delete(
     *     path="/api/projects/{project}",
     *     tags={"Projects"},
     *     summary="Delete a project",
     *     description="Delete a project by its ID",
     *     @OA\Parameter(
     *         name="project",
     *         in="path",
     *         description="ID of the project to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project successfully deleted!")
     *         )
     *     )
     * )
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project successfully deleted!'
        ]);
    }
}
