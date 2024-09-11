<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ToolRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
