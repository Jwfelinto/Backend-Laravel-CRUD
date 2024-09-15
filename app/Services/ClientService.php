<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ClientService
{
    private ClientRepositoryInterface $clientRepository;

    /**
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param $filters
     * @return Collection
     */
    public function getAll($filters): Collection
    {
        return $this->clientRepository->all($filters);
    }

    /**
     * @param array $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $client = new Client([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'cpf_cnpj' => $data['cpf_cnpj'],
        ]);

        return $this->clientRepository->create($client);
    }

    /**
     * @param array $data
     * @param Client $client
     * @return Client
     */
    public function updateClient(array $data, Client $client): Client
    {
        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->cpf_cnpj = $data['cpf_cnpj'];

        return $this->clientRepository->update($client);
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function delete(Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ]);
    }
}
