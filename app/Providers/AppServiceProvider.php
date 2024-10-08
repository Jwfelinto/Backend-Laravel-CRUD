<?php

namespace App\Providers;

use App\Repositories\ClientRepository;
use App\Repositories\InstallationTypeRepository;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\ToolRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\LocationRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ToolRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(InstallationTypeRepositoryInterface::class, InstallationTypeRepository::class);
        $this->app->bind(ToolRepositoryInterface::class, ToolRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
