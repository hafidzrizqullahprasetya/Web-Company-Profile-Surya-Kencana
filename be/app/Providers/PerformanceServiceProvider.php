<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind ImageCacheService to container
        $this->app->singleton('image.cache.service', function ($app) {
            return new \App\Services\ImageCacheService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Optimize memory usage for image processing
        if (config('performance.image_check.use_cache', true)) {
            // Set memory limit for image processing tasks
            ini_set('memory_limit', '512M');
        }

        // Set default cache store to file if database cache is too slow
        if (config('cache.default') === 'database' && app()->environment('production')) {
            // For better performance in production, consider using file or redis cache
            // Only if Redis is not available, fallback to file cache
            if (!config('cache.stores.redis')) {
                config(['cache.default' => 'file']);
            }
        }

        // Set a larger schema string length if using MySQL
        // This helps with performance on larger database schemas
        if (config('database.default') === 'mysql') {
            Schema::defaultStringLength(191);
        }
    }
}