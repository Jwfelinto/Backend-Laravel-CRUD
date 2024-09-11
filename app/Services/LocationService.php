<?php

namespace App\Services;

use App\Repositories\Interfaces\LocationRepositoryInterface;

class LocationService
{
    private LocationRepositoryInterface $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getAll()
    {
        return $this->locationRepository->all();
    }
}
