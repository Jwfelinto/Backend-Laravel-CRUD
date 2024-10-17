<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    private ProjectRepositoryInterface $projectRepository;

    /**
     * @param ProjectRepositoryInterface $projectRepository
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param array|null $data
     * @return LengthAwarePaginator
     */
    public function getProjects(?array $data): LengthAwarePaginator
    {
        $filters = $this->checkFilters($data);

        return $this->projectRepository->all($filters);
    }

    /**
     * @param array $data
     * @return Project
     */
    public function createProject(array $data): Project
    {
        $project = new Project($data);

        $tools = [];
        foreach ($data['tools'] as $tool) {
            $tools[] = [
                'tool_id' => $tool['id'],
                'quantity' => $tool['quantity']
            ];
        }

        return $this->projectRepository->create($project, $tools);
    }

    /**
     * @param array $data
     * @param Project $project
     * @return Project
     */
    public function updateProject(array $data, Project $project)
    {
        $project->client_id = $data['client_id'];
        $project->location_id = $data['location_id'];
        $project->installation_type_id = $data['installation_type_id'];

        $tools = [];
        foreach ($data['tools'] as $tool) {
            $tools[] = [
                'tool_id' => $tool['id'],
                'quantity' => $tool['quantity']
            ];
        }
        return $this->projectRepository->update($project, $tools);

    }

    /**
     * @param array|null $data
     * @return array
     */
    private function checkFilters(?array $data): array
    {
        return [
            'client' => $data['client'] ?? null,
            'location' => $data['location'] ?? null,
            'installation_type' => $data['installation_type'] ?? null,
            'tools' => $data['tools'] ?? null,
            'date' => $data['date'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ];
    }
}
