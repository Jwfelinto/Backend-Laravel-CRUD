<?php

namespace App\Repositories;

use App\Models\InstallationType;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallationTypeRepository implements InstallationTypeRepositoryInterface
{
    private InstallationType $installationType;

    /**
     * @param InstallationType $installationType
     */
    public function __construct(InstallationType $installationType)
    {
        $this->installationType = $installationType;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->installationType->query();

        return $query->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);
    }
}
