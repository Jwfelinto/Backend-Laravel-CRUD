<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    private Project $projects;
    /**
     * @param Project $projects
     */
    /**
     * @param Project $projects
     */
    public function __construct(Project $projects)
    {
        $this->projects = $projects;
    }

    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function all(?array $filters): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->projects->with(['client', 'location', 'tools', 'installationType']);
        $result = $this->applyFilters($query, $filters);

        return $result->latest()->paginate(fn($total) => $pagination == '0' ? $total : $pagination);
    }

    /**
     * @param Project $project
     * @param array $tools
     * @return Project
     */
    public function create(Project $project, array $tools): Project
    {
        $project->save();
        $project->tools()->attach($tools);

        return $project;
    }

    /**
     * @param Project $project
     * @param array $tools
     * @return Project
     */
    public function update(Project $project, array $tools): Project
    {
        $project->save();
        $project->tools()->sync($tools);

        return $project;
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $this->filterClient($query, $filters);
        $this->filterLocation($query, $filters);
        $this->filterInstallationsType($query, $filters);
        $this->filterTools($query, $filters);
        $this->filterDate($query, $filters);
        $this->filterBetweenDate($query, $filters);

        return $query;
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterDate(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['date']), function (Builder $query, $filters) {
            $query->whereDate('created_at', $filters['date']);
        });
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterBetweenDate(Builder $query, ?array $filters): void
    {
        $query
            ->when(! empty($filters['start_date']), function (Builder $query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['start_date']);
            })
            ->when(! empty($filters['end_date']), function (Builder $query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['end_date']);
            });
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterTools(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['tools']), function (Builder $query) use ($filters) {
            $toolsIds = explode(',', $filters['tools']);

            $query->whereHas('tools', function (Builder $toolsQuery) use ($toolsIds) {
                $toolsQuery->whereIn('tools.id', $toolsIds);
            });
        });
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterLocation(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['location']), function (Builder $query, $filters) {
            $query->where('location_id', $filters['location']);
        });
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterClient(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['client']), function (Builder $query, $filters) {
            $query->where('client_id', $filters['client']);
        });
    }

    /**
     * @param Builder $query
     * @param array|null $filters
     * @return void
     */
    private function filterInstallationsType(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['installation_type']), function (Builder $query, $filters) {
            $query->where('installation_type_id', $filters['installation_type']);
        });
    }
}
