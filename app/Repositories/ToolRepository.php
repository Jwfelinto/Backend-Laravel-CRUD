<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Repositories\Interfaces\ToolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ToolRepository implements ToolRepositoryInterface
{
    private Tool $tools;

    /**
     * @param Tool $tools
     */
    public function __construct(Tool $tools)
    {
        $this->tools = $tools;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->tools->all();
    }
}
