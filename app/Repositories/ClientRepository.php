<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository implements ClientRepositoryInterface
{
    private Client $clients;

    public function __construct(Client $clients)
    {
        $this->clients = $clients;
    }

    public function all(?array $filters): Collection
    {
        $query = $this->clients->query();
        $result = $this->applyFilters($query, $filters);

        return $result->orderBy('name', 'ASC')->get();
    }

    public function create(Client $client): Client
    {
        $client->save();

        return $client;
    }

    public function update(Client $client): Client
    {
        $client->save();

        return $client;
    }
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query = $this->filterName($query, $filters['name'] ?? null);
        $query = $this->filterEmail($query, $filters['email']?? null);
        $query = $this->filterPhone($query, $filters['phone'] ?? null);
        $query = $this->filterCpfOrCnpj($query, $filters['cpf_cnpj'] ?? null);

        return $query;
    }

    private function filterName(Builder $query, ?string $name): Builder
    {
        return $query->when($name, function (Builder $query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }

    private function filterEmail(Builder $query, ?string $email): Builder
    {
        return $query->when($email, function (Builder $query, $email) {
            return $query->where('email', 'like', '%' . $email . '%');
        });
    }

    private function filterPhone(Builder $query, ?string $phone): Builder
    {
        return $query->when($phone, function (Builder $query, $phone) {
            return $query->where('phone', 'like', '%' . $phone . '%');
        });
    }

    private function filterCpfOrCnpj(Builder $query, ?string $cpfOrCnpj): Builder
    {
        return $query->when($cpfOrCnpj, function (Builder $query, $cpfOrCnpj) {
            return $query->where('cpf_cnpj', 'like', '%' . $cpfOrCnpj . '%');
        });
    }
}
