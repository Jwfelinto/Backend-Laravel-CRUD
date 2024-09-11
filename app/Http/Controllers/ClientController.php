<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
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

        return ClientResource::collection($clients);
    }

    public function show(Client $client): JsonResource
    {
        return new ClientResource($client);
    }

    public function store(ClientRequest $request): JsonResponse
    {
        $this->clientService->createClient($request->validated());

        return response()->json([
            'message' => 'Client successfully created!'
        ]);
    }

    public function update(ClientRequest $request, Client $client): JsonResponse
    {
        $result = $this->clientService->updateClient($request->validated(), $client);

        return response()->json([
            'message' => 'Client successfully updated!',
            'data' => new ClientResource($result)
        ]);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ]);
    }
}
