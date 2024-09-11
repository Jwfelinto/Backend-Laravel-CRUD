<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface InstallationTypeRepositoryInterface
{
    public function all(): Collection;
}
