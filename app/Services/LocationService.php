<?php

namespace App\Services;

use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->locationRepository->all();
    }
}
