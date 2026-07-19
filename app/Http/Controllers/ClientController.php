<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller
{
    private const FILTERS = [
        'name',
        'email',
        'phone',
        'cpf_cnpj',
    ];

    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $clients = $this->clientService->getAll($filters);

        return ClientsResource::collection($clients);
    }

    public function show(Client $client): JsonResource
    {
        $client->load('projects.installationType');

        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $result = $this->clientService->createClient($request->validated());

        return response()->json([
            'message' => 'Client successfully created!',
            'data' => new ClientResource($result),
        ], 201);
    }

    public function update(Client $client, UpdateClientRequest $request): JsonResponse
    {
        $result = $this->clientService->updateClient($client, $request->validated());

        return response()->json([
            'message' => 'Client successfully updated!',
            'data' => new ClientResource($result),
        ]);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ], 204);
    }
}
