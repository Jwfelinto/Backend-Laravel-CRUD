<?php

namespace App\Services;

use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->installationRepository->all();
    }
}
