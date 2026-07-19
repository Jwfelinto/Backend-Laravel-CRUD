<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    private User $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function all(?array $filters): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->users->query();

        $this->applyFilters($query, $filters);

        return $query->orderBy('name')->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        $this->filterName($query, $filters);
        $this->filterEmail($query, $filters);
    }

    private function filterName(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['name']), function (Builder $query, $filters) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        });
    }

    private function filterEmail(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['email']), function (Builder $query, $filters) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        });
    }
}
