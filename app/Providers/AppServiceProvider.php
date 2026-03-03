<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Application\CarrierService\CarrierRepositoryInterface',
            'App\Infrastructure\Persist\Carrier\CarrierRepositoryUsesBuilder'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
