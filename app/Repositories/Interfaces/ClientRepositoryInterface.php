<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function all(?array $filters): Collection;
    public function create(Client $client):Client;
    public function update(Client $client): Client;
}
