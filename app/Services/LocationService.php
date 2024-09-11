<?php

namespace App\Services;

use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    private LocationRepositoryInterface $locationRepository;

    /**
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->locationRepository->all();
    }
}
