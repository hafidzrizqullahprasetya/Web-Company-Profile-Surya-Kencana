<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

trait StorageImageTrait
{
    /**
     * Build image URL dari path dengan file existence check
     *
     * @param string|null $path
     * @param bool $checkExists - Set false untuk skip check (performance)
     * @return string|null
     */
    public function buildImageUrl(?string $path, bool $checkExists = false): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Check if it's already a full URL (external)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Optional: Check if file exists (dengan cache untuk performance)
        if ($checkExists) {
            $exists = $this->checkFileExists($path);

            if (!$exists) {
                // File tidak ada, cleanup database record
                $this->cleanupMissingImage($path);
                return null;
            }
        }

        $syncEnabled = config('filesystems.sync_enabled', false);
        $primaryDisk = config('filesystems.primary_disk', 'r2');
        $disk = $syncEnabled ? $primaryDisk : config('filesystems.default');

        // Untuk disk public (local storage)
        if ($disk === 'public') {
            return asset('storage/' . $path);
        }

        // Untuk R2 atau S3
        if (in_array($disk, ['r2', 's3'])) {
            // Gunakan URL dari config
            $baseUrl = config("filesystems.disks.{$disk}.url");
            return $baseUrl ? rtrim($baseUrl, '/') . '/' . ltrim($path, '/') : $path;
        }

        // Fallback
        return asset('storage/' . $path);
    }

    /**
     * Check if file exists in storage (dengan cache)
     *
     * @param string $path
     * @return bool
     */
    protected function checkFileExists(string $path): bool
    {
        $cacheKey = 'file_exists:' . md5($path);

        return Cache::remember($cacheKey, 300, function () use ($path) {
            $syncEnabled = config('filesystems.sync_enabled', false);
            $primaryDisk = config('filesystems.primary_disk', 'r2');
            $disk = $syncEnabled ? $primaryDisk : config('filesystems.default');

            try {
                return Storage::disk($disk)->exists($path);
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    /**
     * Cleanup database record ketika file tidak ditemukan
     *
     * @param string $path
     * @return void
     */
    protected function cleanupMissingImage(string $path): void
    {
        try {
            // Null-kan field yang berisi path ini
            $table = $this->getTable();
            $imageFields = $this->getImageFields();

            foreach ($imageFields as $field) {
                // Check if this field contains the missing path
                if ($this->{$field} === $path) {
                    $this->{$field} = null;
                    $this->saveQuietly(); // Save tanpa trigger events

                    \Log::info("Auto-cleaned missing image from {$table}.{$field}: {$path}");
                    break;
                }
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to cleanup missing image: " . $e->getMessage());
        }
    }

    /**
     * Get image field names untuk model ini
     * Override di model jika perlu custom fields
     *
     * @return array
     */
    protected function getImageFields(): array
    {
        // Default image field names
        return ['image_path', 'logo_path', 'background', 'company_logo'];
    }
}
