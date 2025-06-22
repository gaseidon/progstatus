<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AgentRepository;
use App\Services\AgentService;
use App\Repositories\UserRepository;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AgentRepository::class, function ($app) {
            return new AgentRepository();
        });
        $this->app->singleton(AgentService::class, function ($app) {
            return new AgentService($app->make(AgentRepository::class));
        });
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
