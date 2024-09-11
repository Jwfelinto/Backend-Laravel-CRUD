<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository
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
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->locations->all();
    }
}
