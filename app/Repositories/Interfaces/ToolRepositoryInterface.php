<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ToolRepositoryInterface
{
    public function all(): Collection;
}
