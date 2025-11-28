<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImageCacheService
{
    /**
     * Check if file exists in storage and cache the result
     *
     * @param string|null $path
     * @param bool $forceCheck
     * @return bool|null
     */
    public function fileExists(?string $path, bool $forceCheck = false): ?bool
    {
        if (empty($path)) {
            return false;
        }

        // Check if it's already a full URL (external)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }

        $cacheKey = "file_exists:" . md5($path);

        if ($forceCheck) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, 3600, function () use ($path) { // Cache for 1 hour
            $disk = config("filesystems.default");

            try {
                return Storage::disk($disk)->exists($path);
            } catch (\Exception $e) {
                \Log::warning("Error checking file existence: " . $e->getMessage(), [
                    'path' => $path,
                    'disk' => $disk
                ]);
                return false;
            }
        });
    }

    /**
     * Build image URL with cached file existence check
     *
     * @param string|null $path
     * @param bool $checkExists
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

        $disk = config("filesystems.default");

        // Optional: Check if file exists (using cached result)
        if ($checkExists) {
            $exists = $this->fileExists($path);
            if (!$exists) {
                return null; // File doesn't exist, return null
            }
        }

        // For public disk
        if ($disk === "public") {
            return asset("storage/" . $path);
        }

        // For R2 or S3
        if (in_array($disk, ["r2", "s3"])) {
            $baseUrl = config("filesystems.disks.{$disk}.url");
            return $baseUrl
                ? rtrim($baseUrl, "/") . "/" . ltrim($path, "/")
                : $path;
        }

        // Fallback
        return Storage::disk($disk)->url($path);
    }

    /**
     * Get multiple image URLs efficiently
     *
     * @param array $paths
     * @param bool $checkExists
     * @return array
     */
    public function buildImageUrls(array $paths, bool $checkExists = false): array
    {
        if (empty($paths)) {
            return [];
        }

        $results = [];
        
        foreach ($paths as $path) {
            $results[] = $this->buildImageUrl($path, $checkExists);
        }

        return $results;
    }
}