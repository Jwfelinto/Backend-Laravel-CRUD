<?php

namespace App\Services;

use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallationTypeService
{
    private InstallationTypeRepositoryInterface $installationRepository;

    public function __construct(InstallationTypeRepositoryInterface $installationRepository)
    {
        $this->installationRepository = $installationRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->installationRepository->all();
    }
}
