<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OurClient;
use App\Models\CompanyHistory;
use App\Models\Hero;
use App\Models\SiteSetting;

class CleanupMissingImages extends Command
{
    protected $signature = 'storage:cleanup-missing
                          {--dry-run : Hanya tampilkan yang akan dihapus tanpa eksekusi}
                          {--disk=r2 : Disk untuk check file (r2 atau public)}';

    protected $description = 'Cleanup database records untuk file yang tidak ada di storage';

    protected $cleaned = 0;
    protected $scanned = 0;

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $disk = $this->option('disk');

        $this->info("🔍 Scanning for missing images...");
        $this->info("   Disk: {$disk}");
        $this->info("   Mode: " . ($isDryRun ? 'DRY RUN (no changes)' : 'LIVE (will update DB)'));
        $this->newLine();

        // Check Products
        $this->checkProducts($disk, $isDryRun);

        // Check OurClients
        $this->checkClients($disk, $isDryRun);

        // Check Company Histories
        $this->checkHistories($disk, $isDryRun);

        // Check Heroes
        $this->checkHeroes($disk, $isDryRun);

        // Check Site Settings
        $this->checkSettings($disk, $isDryRun);

        $this->newLine();
        $this->info("=" . str_repeat("=", 60));
        $this->info("✨ Cleanup Complete!");
        $this->info("   Scanned: {$this->scanned} records");
        $this->info("   Cleaned: {$this->cleaned} records");

        if ($isDryRun) {
            $this->warn("\n⚠️  DRY RUN mode - No changes made to database");
            $this->info("Run without --dry-run to apply changes");
        }

        return 0;
    }

    protected function checkProducts($disk, $isDryRun)
    {
        $this->info("📦 Checking Products...");

        $products = Product::whereNotNull('image_path')->get();

        foreach ($products as $product) {
            $this->scanned++;

            if (!Storage::disk($disk)->exists($product->image_path)) {
                $this->warn("   ❌ Missing: products/{$product->id} - {$product->image_path}");

                if (!$isDryRun) {
                    $product->delete(); // atau set null: $product->update(['image_path' => null]);
                    $this->cleaned++;
                }
            }
        }

        $this->info("   ✓ Checked {$products->count()} products\n");
    }

    protected function checkClients($disk, $isDryRun)
    {
        $this->info("🤝 Checking Clients...");

        $clients = OurClient::whereNotNull('logo_path')->get();

        foreach ($clients as $client) {
            $this->scanned++;

            if (!Storage::disk($disk)->exists($client->logo_path)) {
                $this->warn("   ❌ Missing: clients/{$client->id} - {$client->logo_path}");

                if (!$isDryRun) {
                    $client->delete();
                    $this->cleaned++;
                }
            }
        }

        $this->info("   ✓ Checked {$clients->count()} clients\n");
    }

    protected function checkHistories($disk, $isDryRun)
    {
        $this->info("📜 Checking Company Histories...");

        $histories = CompanyHistory::whereNotNull('image_path')->get();

        foreach ($histories as $history) {
            $this->scanned++;

            if (!Storage::disk($disk)->exists($history->image_path)) {
                $this->warn("   ❌ Missing: histories/{$history->id} - {$history->image_path}");

                if (!$isDryRun) {
                    $history->delete();
                    $this->cleaned++;
                }
            }
        }

        $this->info("   ✓ Checked {$histories->count()} histories\n");
    }

    protected function checkHeroes($disk, $isDryRun)
    {
        $this->info("🦸 Checking Heroes...");

        $heroes = Hero::all();

        foreach ($heroes as $hero) {
            $needsCleanup = false;

            if ($hero->backgrounds && is_array($hero->backgrounds)) {
                $validBackgrounds = [];

                foreach ($hero->backgrounds as $bg) {
                    $this->scanned++;

                    if (Storage::disk($disk)->exists($bg)) {
                        $validBackgrounds[] = $bg;
                    } else {
                        $this->warn("   ❌ Missing: hero/{$hero->id} background - {$bg}");
                        $needsCleanup = true;
                    }
                }

                if ($needsCleanup && !$isDryRun) {
                    $hero->update(['backgrounds' => $validBackgrounds]);
                    $this->cleaned++;
                }
            }
        }

        $this->info("   ✓ Checked {$heroes->count()} heroes\n");
    }

    protected function checkSettings($disk, $isDryRun)
    {
        $this->info("⚙️  Checking Site Settings...");

        $settings = SiteSetting::whereNotNull('company_logo')->get();

        foreach ($settings as $setting) {
            $this->scanned++;

            if (!Storage::disk($disk)->exists($setting->company_logo)) {
                $this->warn("   ❌ Missing: settings/{$setting->id} logo - {$setting->company_logo}");

                if (!$isDryRun) {
                    $setting->update(['company_logo' => null]);
                    $this->cleaned++;
                }
            }
        }

        $this->info("   ✓ Checked {$settings->count()} settings\n");
    }
}
