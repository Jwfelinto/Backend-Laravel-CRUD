<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator;

    /**
     * @param User $user
     * @return User
     */
    public function create(User $user):User;

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user): User;
}
