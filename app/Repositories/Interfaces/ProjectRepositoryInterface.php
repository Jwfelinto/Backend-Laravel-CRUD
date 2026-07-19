<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function all(?array $filters): LengthAwarePaginator;
    public function save(Project $project, array $tools): Project;
}
