<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    /**
     * @param array|null $filters
     * @return Collection
     */
    public function all(?array $filters): Collection;

    /**
     * @param Project $project
     * @param array $tools
     * @return Project
     */
    public function create(Project $project, array $tools):Project;

    /**
     * @param Project $project
     * @param array $tools
     * @return Project
     */
    public function update(Project $project, array $tools): Project;
}
