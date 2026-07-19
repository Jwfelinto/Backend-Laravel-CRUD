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
        return $this->projectRepository->all($data);
    }

    /**
     * @param array $data
     * @return Project
     */
    public function createProject(array $data): Project
    {
        $project = new Project($data);

        return $this->projectRepository->create(
            $project,
            $this->formatTools($data['tools'])
        );
    }

    public function updateProject(array $data, Project $project): Project
    {
        $project->fill($data);

        return $this->projectRepository->update(
            $project,
            $this->formatTools($data['tools'])
        );
    }

    private function formatTools(array $tools): array
    {
        return collect($tools)
            ->mapWithKeys(fn($tool) => [
                $tool['id'] => [
                    'quantity' => $tool['quantity'],
                ],
            ])
            ->toArray();
    }
}
