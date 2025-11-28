<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearAllCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-all
                            {--force : Force clearing without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all application caches including landing page, products, clients, etc.';

    /**
     * List of cache keys to clear
     *
     * @var array
     */
    protected $cacheKeys = [
        'landing_page_data',
        'products_with_clients',
        'our_clients_all',
        'testimonials_all',
        'admins_all',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to clear all application caches?')) {
                $this->info('Cache clearing cancelled.');
                return Command::SUCCESS;
            }
        }

        $this->info('Clearing application caches...');
        $this->newLine();

        // Clear specific cache keys
        $clearedCount = 0;
        $failedCount = 0;

        foreach ($this->cacheKeys as $key) {
            try {
                if (Cache::forget($key)) {
                    $this->line("✓ Cleared cache: <info>{$key}</info>");
                    $clearedCount++;
                } else {
                    $this->line("- Cache not found or already cleared: <comment>{$key}</comment>");
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to clear cache: {$key}");
                $this->error("  Error: {$e->getMessage()}");
                $failedCount++;
            }
        }

        $this->newLine();

        // Clear Laravel's default caches
        $this->info('Clearing Laravel default caches...');

        try {
            $this->call('cache:clear');
            $this->line('✓ Application cache cleared');
        } catch (\Exception $e) {
            $this->error('✗ Failed to clear application cache');
            $failedCount++;
        }

        try {
            $this->call('config:clear');
            $this->line('✓ Configuration cache cleared');
        } catch (\Exception $e) {
            $this->error('✗ Failed to clear configuration cache');
            $failedCount++;
        }

        try {
            $this->call('route:clear');
            $this->line('✓ Route cache cleared');
        } catch (\Exception $e) {
            $this->error('✗ Failed to clear route cache');
            $failedCount++;
        }

        try {
            $this->call('view:clear');
            $this->line('✓ View cache cleared');
        } catch (\Exception $e) {
            $this->error('✗ Failed to clear view cache');
            $failedCount++;
        }

        $this->newLine();

        // Summary
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('Cache Clearing Summary');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line("Specific caches cleared: <info>{$clearedCount}</info>");

        if ($failedCount > 0) {
            $this->line("Failed operations: <error>{$failedCount}</error>");
            $this->newLine();
            $this->warn('⚠ Some caches could not be cleared. Check the errors above.');
            return Command::FAILURE;
        }

        $this->newLine();
        $this->info('✓ All caches cleared successfully!');

        return Command::SUCCESS;
    }
}
