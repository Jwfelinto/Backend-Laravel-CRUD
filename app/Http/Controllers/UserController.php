<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    const FILTERS = [
        'name',
        'email'
    ];

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResource
    {
        $filters = $request->only(self::FILTERS);
        $users = $this->userService->getAll($filters);

        return UsersResource::collection($users);
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $users = $this->userService->registerUser($request->validated());

        return response()->json([
            'message' => 'User successfully created.',
            'data' => new UserResource($users)
        ], 201);
    }

    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->updateUser($request->validated(), $user);

        return response()->json([
            'message' => 'User successfully updated.',
            'data' => new UserResource($user)
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        return response()->json([
            'message' => 'User successfully deleted',
        ], 204);
    }
}
