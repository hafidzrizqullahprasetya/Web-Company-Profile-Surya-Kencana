<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageCacheService
{
    public function fileExists(?string $path, bool $forceCheck = false): ?bool
    {
        if (empty($path)) {
            return false;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }

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
    }

    public function buildImageUrl(?string $path, bool $checkExists = false): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $disk = config("filesystems.default");

        if ($checkExists) {
            $exists = $this->fileExists($path);
            if (!$exists) {
                return null;
            }
        }

        if ($disk === "public") {
            return asset("storage/" . $path);
        }

        if (in_array($disk, ["r2", "s3"])) {
            $baseUrl = config("filesystems.disks.{$disk}.url");
            return $baseUrl
                ? rtrim($baseUrl, "/") . "/" . ltrim($path, "/")
                : $path;
        }

        return Storage::disk($disk)->url($path);
    }

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
