<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageService
{
    /**
     * Upload file ke storage dengan dual sync support
     * Auto-convert ke WebP untuk performa optimal
     * File akan diupload ke local storage DAN R2 sekaligus jika STORAGE_SYNC=true
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param bool $convertToWebp - Auto-convert ke WebP (default: true)
     * @return string Path file yang disimpan
     */
    public function upload(UploadedFile $file, string $folder = '', bool $convertToWebp = true): string
    {
        // Generate nama file yang unik
        $originalExtension = $file->getClientOriginalExtension();
        $uuid = Str::uuid();

        // Jika convert to WebP enabled dan file adalah image
        if ($convertToWebp && $this->isConvertibleImage($originalExtension)) {
            $filename = $uuid . '.webp';
            $fileContents = $this->convertToWebP($file);
        } else {
            $filename = $uuid . '.' . $originalExtension;
            $fileContents = file_get_contents($file->getRealPath());
        }

        // Tentukan path lengkap
        $path = $folder ? "{$folder}/{$filename}" : $filename;

        // Cek mode sync
        $syncEnabled = config('filesystems.sync_enabled', false);

        if ($syncEnabled) {
            // Mode SYNC: Upload ke kedua storage (public dan r2)

            // Upload ke local storage
            Storage::disk('public')->put($path, $fileContents);

            // Upload ke R2
            try {
                Storage::disk('r2')->put($path, $fileContents);
            } catch (\Exception $e) {
                // Log error tapi tetap lanjut (fallback ke local saja)
                \Log::warning("R2 sync failed for {$path}: " . $e->getMessage());
            }
        } else {
            // Mode SINGLE: Upload hanya ke disk yang aktif
            Storage::disk(config('filesystems.default'))->put($path, $fileContents);
        }

        return $path;
    }

    /**
     * Check if file extension is convertible to WebP
     *
     * @param string $extension
     * @return bool
     */
    protected function isConvertibleImage(string $extension): bool
    {
        $convertible = ['jpg', 'jpeg', 'png', 'gif'];
        return in_array(strtolower($extension), $convertible);
    }

    /**
     * Convert image to WebP format
     *
     * @param UploadedFile $file
     * @param int $quality - WebP quality (0-100, default: 85)
     * @return string Binary content of WebP image
     */
    protected function convertToWebP(UploadedFile $file, int $quality = 85): string
    {
        $sourcePath = $file->getRealPath();
        $extension = strtolower($file->getClientOriginalExtension());

        // Create image resource based on file type
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'png':
                $image = @imagecreatefrompng($sourcePath);
                // Preserve transparency
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'gif':
                $image = @imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception("Unsupported image format: {$extension}");
        }

        if (!$image) {
            throw new \Exception("Failed to create image resource from: {$sourcePath}");
        }

        // Convert to WebP using output buffering
        ob_start();
        imagewebp($image, null, $quality);
        $webpContent = ob_get_clean();

        // Free memory
        imagedestroy($image);

        return $webpContent;
    }

    /**
     * Delete file dari storage (dengan dual sync support)
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // Jika path adalah URL penuh, skip delete
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return false;
        }

        $syncEnabled = config('filesystems.sync_enabled', false);
        $success = false;

        if ($syncEnabled) {
            // Mode SYNC: Delete dari kedua storage

            // Delete dari local
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                $success = true;
            }

            // Delete dari R2
            try {
                if (Storage::disk('r2')->exists($path)) {
                    Storage::disk('r2')->delete($path);
                }
            } catch (\Exception $e) {
                \Log::warning("R2 delete sync failed for {$path}: " . $e->getMessage());
            }
        } else {
            // Mode SINGLE: Delete hanya dari disk yang aktif
            $success = Storage::disk(config('filesystems.default'))->delete($path);
        }

        return $success;
    }

    /**
     * Get URL file berdasarkan storage yang aktif
     * Jika sync mode, selalu return URL dari primary disk (R2 atau public)
     *
     * @param string $path
     * @return string|null
     */
    public function getUrl(string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Jika sudah URL penuh, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $syncEnabled = config('filesystems.sync_enabled', false);
        $primaryDisk = config('filesystems.primary_disk', 'r2'); // Default primary adalah R2

        // Jika sync mode, gunakan primary disk untuk URL
        $disk = $syncEnabled ? $primaryDisk : config('filesystems.default');

        // Untuk disk public (local storage)
        if ($disk === 'public') {
            return asset('storage/' . $path);
        }

        // Untuk R2 atau S3, gunakan URL() dari Storage
        if (in_array($disk, ['r2', 's3'])) {
            return Storage::disk($disk)->url($path);
        }

        // Fallback
        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if file exists
     *
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return false;
        }

        return Storage::disk(config('filesystems.default'))->exists($path);
    }
}
