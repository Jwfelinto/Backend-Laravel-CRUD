<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ToolRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;
}
