<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationRepository implements LocationRepositoryInterface
{
    private Location $locations;

    /**
     * @param Location $locations
     */
    public function __construct(Location $locations)
    {
        $this->locations = $locations;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->locations->query();
        return $query->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);

    }
}
