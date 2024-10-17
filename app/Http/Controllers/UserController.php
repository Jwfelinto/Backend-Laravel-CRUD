<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * @var array
     */
    const FILTERS = [
        'name',
        'email'
    ];

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $users = $this->userService->getAll($filters);

        return UserResource::collection($users);
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        $users = $this->userService->registerUser($request->validated());

        return response()->json([
            'message' => 'User successfully created.',
            'data' => new UserResource($users)
        ], 201);
    }

    /**
     * @param User $user
     * @return JsonResource
     */
    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->updateUser($request->validated(), $user);

        return response()->json([
            'message' => 'User successfully updated.',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
       $this->userService->deleteUser($user);

        return response()->json([
            'message' => 'User successfully deleted',
        ], 204);
    }
}
