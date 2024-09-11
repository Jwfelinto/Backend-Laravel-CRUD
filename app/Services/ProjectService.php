<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    private ProjectRepositoryInterface $projectRepository;
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProjects(?array $data): Collection
    {
        $filters = $this->checkFilters($data);

        return $this->projectRepository->all($filters);
    }

    public function createProject(array $data): Project
    {
        $project = new Project([
            'client_id' => $data['client_id'],
            'location_id' => $data['location_id'],
            'installation_type_id' => $data['installation_type_id'],
        ]);

        $tools = [];
        foreach ($data['tools'] as $tool) {
            $tools[] = [
                'tool_id' => $tool['id'],
                'quantity' => $tool['quantity']
            ];
        }

        return $this->projectRepository->create($project, $tools);
    }

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
