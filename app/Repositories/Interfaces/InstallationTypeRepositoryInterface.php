<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface InstallationTypeRepositoryInterface
{
    public function all(): LengthAwarePaginator;
}
