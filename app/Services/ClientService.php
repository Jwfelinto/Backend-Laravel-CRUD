<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     */
    public function getAll($filters): LengthAwarePaginator
    {
        return $this->clientRepository->all($filters);
    }

    /**
     * @param array $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $client = new Client($data);

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
    public function delete(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ]);
    }
}
