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
        // --- FIX CLOUDFLARE FLEXIBLE MODE ---
        if ($this->app->environment('production')) {
            // 1. Generate semua link (CSS/JS/Route) pakai HTTPS
            URL::forceScheme('https');

            // 2. HACK PENTING: Bohongi Laravel bahwa request ini adalah HTTPS
            // Ini mencegah error "The page isn’t redirecting properly"
            $this->app['request']->server->set('HTTPS', 'on');
        }

        // Optimize performance
        if (config('performance.query_optimization.enable_query_cache', true)) {
            if (app()->environment('local', 'development')) {
                DB::enableQueryLog();
            }
        }
    }
}
