<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationRepository implements LocationRepositoryInterface
{
    private Location $locations;

    public function __construct(Location $locations)
    {
        $this->locations = $locations;
    }

    public function all(): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->locations->query();

        return $query->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);
    }
}
