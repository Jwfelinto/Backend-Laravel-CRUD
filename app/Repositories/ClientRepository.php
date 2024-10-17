<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var Client $clients
     */
    private Client $clients;

    /**
     * @param Client $clients
     */
    public function __construct(Client $clients)
    {
        $this->clients = $clients;
    }

    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);


        $query = $this->clients->query();
        $result = $this->applyFilters($query, $filters);

        return $result->orderBy('name', 'ASC')->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);
    }

    /**
     * @param Client $client
     * @return Client
     */
    public function create(Client $client): Client
    {
        $client->save();

        return $client;
    }

    /**
     * @param Client $client
     * @return Client
     */
    public function update(Client $client): Client
    {
        $client->save();

        return $client;
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query = $this->filterName($query, $filters['name'] ?? null);
        $query = $this->filterEmail($query, $filters['email']?? null);
        $query = $this->filterPhone($query, $filters['phone'] ?? null);
        $query = $this->filterCpfOrCnpj($query, $filters['cpf_cnpj'] ?? null);

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    private function filterName(Builder $query, ?string $name): Builder
    {
        return $query->when($name, function (Builder $query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string|null $email
     * @return Builder
     */
    private function filterEmail(Builder $query, ?string $email): Builder
    {
        return $query->when($email, function (Builder $query, $email) {
            return $query->where('email', 'like', '%' . $email . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string|null $phone
     * @return Builder
     */
    private function filterPhone(Builder $query, ?string $phone): Builder
    {
        return $query->when($phone, function (Builder $query, $phone) {
            return $query->where('phone', 'like', '%' . $phone . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string|null $cpfOrCnpj
     * @return Builder
     */
    private function filterCpfOrCnpj(Builder $query, ?string $cpfOrCnpj): Builder
    {
        return $query->when($cpfOrCnpj, function (Builder $query, $cpfOrCnpj) {
            return $query->where('cpf_cnpj', 'like', '%' . $cpfOrCnpj . '%');
        });
    }
}
