<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator;

    /**
     * @param Client $client
     * @return Client
     */
    public function save(Client $client):Client;
}
