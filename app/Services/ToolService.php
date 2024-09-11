<?php

namespace App\Services;


use App\Repositories\Interfaces\ToolRepositoryInterface;

class ToolService
{
    private ToolRepositoryInterface $toolRepository;

    public function __construct(ToolRepositoryInterface $toolRepository)
    {
        $this->toolRepository = $toolRepository;
    }

    public function getAll()
    {
        return $this->toolRepository->all();
    }
}
