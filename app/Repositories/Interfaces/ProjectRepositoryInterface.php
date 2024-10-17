<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator;

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
