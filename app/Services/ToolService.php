<?php

namespace App\Services;


use App\Repositories\Interfaces\ToolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ToolService
{
    private ToolRepositoryInterface $toolRepository;

    /**
     * @param ToolRepositoryInterface $toolRepository
     */
    public function __construct(ToolRepositoryInterface $toolRepository)
    {
        $this->toolRepository = $toolRepository;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->toolRepository->all();
    }
}
