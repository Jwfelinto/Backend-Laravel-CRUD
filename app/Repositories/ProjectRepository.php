<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    private Project $projects;

    public function __construct(Project $projects)
    {
        $this->projects = $projects;
    }

    public function all(?array $filters): LengthAwarePaginator
    {
        $pagination = request('pagination', 10);

        $query = $this->projects->with(['client', 'location', 'tools', 'installationType']);
        $result = $this->applyFilters($query, $filters);

        return $result->latest()->paginate(fn($total) => $pagination == '0' ? $total : $pagination);
    }

    public function save(Project $project, array $tools): Project
    {
        $project->save();
        $project->tools()->sync($tools);

        $project->load('client', 'location', 'installationType', 'tools.pivot');

        return $project;
    }

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

    private function filterDate(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['date']), function (Builder $query, $filters) {
            $query->whereDate('created_at', $filters['date']);
        });
    }

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

    private function filterTools(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['tools']), function (Builder $query) use ($filters) {
            $toolsIds = explode(',', $filters['tools']);

            $query->whereHas('tools', function (Builder $toolsQuery) use ($toolsIds) {
                $toolsQuery->whereIn('tools.id', $toolsIds);
            });
        });
    }

    private function filterLocation(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['location']), function (Builder $query, $filters) {
            $query->where('location_id', $filters['location']);
        });
    }

    private function filterClient(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['client']), function (Builder $query, $filters) {
            $query->where('client_id', $filters['client']);
        });
    }

    private function filterInstallationsType(Builder $query, ?array $filters): void
    {
        $query->when(! empty($filters['installation_type']), function (Builder $query, $filters) {
            $query->where('installation_type_id', $filters['installation_type']);
        });
    }
}
