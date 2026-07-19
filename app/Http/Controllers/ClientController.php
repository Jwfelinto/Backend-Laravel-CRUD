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

    /**
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $clients = $this->clientService->getAll($filters);

        return ClientsResource::collection($clients);
    }

    /**
     * @param Client $client
     * @return JsonResource
     */
    public function show(Client $client): JsonResource
    {
        $client->load('projects.installationType');

        return new ClientResource($client);
    }

    /**
     * @param StoreClientRequest $request
     * @return JsonResponse
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        $result = $this->clientService->createClient($request->validated());

        return response()->json([
            'message' => 'Client successfully created!',
            'data' => new ClientResource($result),
        ], 201);
    }

    /**
     * @param UpdateClientRequest $request
     * @param Client $client
     * @return JsonResponse
     */
    public function update(Client $client, UpdateClientRequest $request): JsonResponse
    {
        $result = $this->clientService->updateClient($client, $request->validated());

        return response()->json([
            'message' => 'Client successfully updated!',
            'data' => new ClientResource($result),
        ]);
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ], 204);
    }
}
