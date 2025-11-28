<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Optimize performance
        if (config('performance.query_optimization.enable_query_cache', true)) {
            // Enable query logging in development to help with optimization
            if (app()->environment('local', 'development')) {
                DB::enableQueryLog();
            }
        }
    }
}
