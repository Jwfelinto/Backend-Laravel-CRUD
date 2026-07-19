<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAll($filters): LengthAwarePaginator
    {
        return $this->clientRepository->all($filters);
    }

    public function createClient(array $data): Client
    {
        $client = new Client($data);

        return $this->clientRepository->save($client);
    }

    public function updateClient(Client $client, array $data): Client
    {
        $client->fill($data);

        return $this->clientRepository->save($client);
    }

    public function delete(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ]);
    }
}
