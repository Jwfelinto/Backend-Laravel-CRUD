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
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="API Endpoints for Client"
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
     * @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ClientResource"))
     * )
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $clients = $this->clientService->getAll($filters);

        return ClientResource::collection($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{client}",
     *     tags={"Clients"},
     *     summary="Show a client",
     *     description="Return a single client by ID",
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
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="cpf_cnpj", type="string", example="123.456.789-00"),
     *             @OA\Property(property="projects", type="array", @OA\Items(ref="#/components/schemas/ProjectResource"))
     *         )
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
     *     path="/api/clientes",
     *     tags={"Clients"},
     *     summary="Create a new client",
     *     description="Create a new client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "cpf_cnpj"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="cpf_cnpj", type="string", example="123.456.789-00")
     *         )
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
     *     path="/api/clientes/{client}",
     *     tags={"Clients"},
     *     summary="Update a client",
     *     description="Update a client by ID",
     *     @OA\Parameter(
     *         name="client",
     *         in="path",
     *         description="ID of the client to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="cpf_cnpj", type="string", example="123.456.789-00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
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
     *         response=204,
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
        ], 204);
    }
}
