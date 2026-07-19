<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ToolRepositoryInterface
{
    public function all(): LengthAwarePaginator;
}
