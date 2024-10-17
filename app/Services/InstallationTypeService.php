<?php

namespace App\Services;

use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallationTypeService
{
    private InstallationTypeRepositoryInterface $installationRepository;

    /**
     * @param InstallationTypeRepositoryInterface $installationRepository
     */
    public function __construct(InstallationTypeRepositoryInterface $installationRepository)
    {
        $this->installationRepository = $installationRepository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->installationRepository->all();
    }
}
