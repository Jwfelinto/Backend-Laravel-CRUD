<?php

namespace App\Services;


use App\Repositories\Interfaces\ToolRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ToolService
{
    private ToolRepositoryInterface $toolRepository;

    public function __construct(ToolRepositoryInterface $toolRepository)
    {
        $this->toolRepository = $toolRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->toolRepository->all();
    }
}
