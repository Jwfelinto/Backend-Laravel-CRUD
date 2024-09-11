<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface LocationRepositoryInterface
{
    public function all(): Collection;
}
