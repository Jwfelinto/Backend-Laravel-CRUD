<?php

namespace App\Repositories;

use App\Models\InstallationType;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InstallationTypeRepository implements InstallationTypeRepositoryInterface
{
    private InstallationType $installationType;

    /**
     * @param InstallationType $installationType
     */
    public function __construct(InstallationType $installationType)
    {
        $this->installationType = $installationType;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->installationType->all();
    }
}
