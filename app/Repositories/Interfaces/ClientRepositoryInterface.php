<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    public function all(?array $filters): LengthAwarePaginator;
    public function save(Client $client):Client;
}
