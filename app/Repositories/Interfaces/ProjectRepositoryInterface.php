<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function all(?array $filters): Collection;
    public function create(Project $project, array $tools):Project;
    public function update(Project $project, array $tools): Project;
}
