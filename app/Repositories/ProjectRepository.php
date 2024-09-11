<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    private Project $projects;

    /**
     * @param Project $projects
     */
    public function __construct(Project $projects)
    {
        $this->projects = $projects;
    }

    public function all(?array $filters): Collection
    {
        $query = $this->projects->with(['client', 'location', 'tools', 'installationType']);
        $result = $this->applyFilters($query, $filters);

        return $result->latest()->get();
    }

    public function create(Project $project, array $tools): Project
    {
        $project->save();
        $project->tools()->attach($tools);

        return $project;
    }

    public function update(Project $project, array $tools): Project
    {
        $project->save();
        $project->tools()->sync($tools);

        return $project;
    }
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query = $this->filterClient($query, $filters['client']);
        $query = $this->filterLocation($query, $filters['location']);
        $query = $this->filterInstallationsType($query, $filters['installation_type']);
        $query = $this->filterTools($query, $filters['tools']);
        $query = $this->filterDate($query, $filters['date']);
        $query = $this->filterBetweenDate($query, $filters['start_date'], $filters['end_date']);

        return $query;
    }

    private function filterDate(Builder $query, ?string $date): Builder
    {
        return $query->when($date, function (Builder $query, $date) {
            return $query->whereDate('created_at', date('Y-m-d', strtotime($date)));
        });
    }

    private function filterBetweenDate(Builder $query, ?string $startDate, ?string $endDate): Builder
    {
        return $query->when(($startDate) && ($endDate), function (Builder $query) use ($startDate, $endDate) {
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));

            return $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        });
    }

    private function filterTools(Builder $query, ?int $tools): Builder
    {
        return $query->when($tools, function (Builder $query) use ($tools) {
                $toolsIds = explode(',', $tools);
                return $query->whereHas('tools', function (Builder $toolsQuery) use ($toolsIds) {
                    $toolsQuery->whereIn('id', $toolsIds);
                });
            });
    }

    private function filterLocation(Builder $query, ?int $location): Builder
    {
        return $query->when($location, function (Builder $query, $location) {
            return $query->where('location_id', $location);
        });
    }

    private function filterClient(Builder $query, ?int $client): Builder
    {
        return $query->when($client, function (Builder $query, $client) {
            return $query->where('client_id', $client);
        });
    }

    private function filterInstallationsType(Builder $query, ?int $installationType): Builder
    {
        return $query->when($installationType, function (Builder $query, $installationType) {
            return $query->where('installation_type_id', $installationType);
        });
    }
}
