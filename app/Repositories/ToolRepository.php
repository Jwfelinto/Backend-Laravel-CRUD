<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Repositories\Interfaces\ToolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->tools->query();

        return $query->paginate(fn ($total) => $pagination == '0' ? $total : $pagination);
    }
}
