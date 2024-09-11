<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface InstallationTypeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
