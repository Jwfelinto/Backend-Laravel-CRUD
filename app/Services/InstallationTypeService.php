<?php

namespace App\Services;

use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;

class InstallationTypeService
{
    private InstallationTypeRepositoryInterface $installationRepository;

    public function __construct(InstallationTypeRepositoryInterface $installationRepository)
    {
        $this->installationRepository = $installationRepository;
    }

    public function getAll()
    {
        return $this->installationRepository->all();
    }
}
