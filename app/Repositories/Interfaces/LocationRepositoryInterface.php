<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface LocationRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
