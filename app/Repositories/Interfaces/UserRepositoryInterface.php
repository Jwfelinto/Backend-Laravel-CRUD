<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @param array|null $filters
     * @return Collection
     */
    public function all(?array $filters): Collection;

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
