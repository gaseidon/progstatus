<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AgentRepository;
use App\Services\AgentService;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
