<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private User $users;

    /**
     * @param User $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->users->query();
        $result = $this->applyFilters($query, $filters);

        return $result->orderBy('name')->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);

    }

    /**
     * @param User $user
     * @return User
     */
    public function create(User $user): User
    {
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user): User
    {
        $user->save();

        return $user;
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query = $this->filterName($query, $filters['name'] ?? null);
        $query = $this->filterEmail($query, $filters['email']?? null);

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    private function filterName(Builder $query, ?string $name): Builder
    {
        return $query->when($name, function (Builder $query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string|null $email
     * @return Builder
     */
    private function filterEmail(Builder $query, ?string $email): Builder
    {
        return $query->when($email, function (Builder $query, $email) {
            return $query->where('email', 'like', '%' . $email . '%');
        });
    }
}
