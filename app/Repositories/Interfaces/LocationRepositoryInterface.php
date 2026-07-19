<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface LocationRepositoryInterface
{
    public function all(): LengthAwarePaginator;
}
