<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(?array $data): LengthAwarePaginator
    {
        return $this->userRepository->all($data);
    }

    public function registerUser(array $data): User
    {
        return $this->userRepository->create(
            $this->fillUser(new User(), $data)
        );
    }

    public function updateUser(array $data, User $user): User
    {
        return $this->userRepository->update(
            $this->fillUser($user, $data)
        );
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    private function fillUser(User $user, array $data): User
    {
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }
}
