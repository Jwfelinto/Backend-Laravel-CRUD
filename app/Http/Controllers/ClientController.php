<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Client API",
 *     description="API for managing clients"
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local API Server"
 * )
 *
 * @OA\PathItem(
 *     path="/api/clients"
 * )
 *
 * @OA\PathItem(
 *     path="/api/clients/{client}"
 * )
 *
 * @OA\Tag(
 *     name="Clients",
 *     description="API Endpoints for Clients"
 * )
 */
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
     * @OA\Get(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="List all clients",
     *     description="Return a list of clients with optional filters",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by client name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Filter by client email",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Filter by client phone",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cpf_cnpj",
     *         in="query",
     *         description="Filter by client CPF or CNPJ",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ClientResource"))
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $clients = $this->clientService->getAll($filters);

        return ClientResource::collection($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/clients/{client}",
     *     tags={"Clients"},
     *     summary="Show a client",
     *     description="Return a single client",
     *     @OA\Parameter(
     *         name="client",
     *         in="path",
     *         description="ID of the client to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ClientResource")
     *     )
     * )
     *
     * @param Client $client
     * @return JsonResource
     */
    public function show(Client $client): JsonResource
    {
        return new ClientResource($client);
    }

    /**
     * @OA\Post(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="Create a new client",
     *     description="Create a new client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client successfully created!")
     *         )
     *     )
     * )
     *
     * @param ClientRequest $request
     * @return JsonResponse
     */
    public function store(ClientRequest $request): JsonResponse
    {
        $this->clientService->createClient($request->validated());

        return response()->json([
            'message' => 'Client successfully created!'
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/clients/{client}",
     *     tags={"Clients"},
     *     summary="Update an existing client",
     *     description="Update an existing client",
     *     @OA\Parameter(
     *         name="client",
     *         in="path",
     *         description="ID of the client to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client successfully updated!"),
     *             @OA\Property(property="data", ref="#/components/schemas/ClientResource")
     *         )
     *     )
     * )
     *
     * @param ClientRequest $request
     * @param Client $client
     * @return JsonResponse
     */
    public function update(ClientRequest $request, Client $client): JsonResponse
    {
        $result = $this->clientService->updateClient($request->validated(), $client);

        return response()->json([
            'message' => 'Client successfully updated!',
            'data' => new ClientResource($result)
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{client}",
     *     tags={"Clients"},
     *     summary="Delete a client",
     *     description="Delete a client by its ID",
     *     @OA\Parameter(
     *         name="client",
     *         in="path",
     *         description="ID of the client to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client successfully deleted!")
     *         )
     *     )
     * )
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client successfully deleted!'
        ],204);
    }
}
