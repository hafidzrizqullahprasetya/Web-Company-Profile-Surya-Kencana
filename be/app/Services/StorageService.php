<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use Intervention\Image\Laravel\Facades\Image;

class StorageService
{
    protected $defaultDisk = 'r2';

    public function __construct()
    {
        // Ensure we're using R2 as default, or fallback to s3 if R2 is not configured
        $this->defaultDisk = $this->getDefaultDisk();

        // Force R2 usage to ensure all files are stored in R2
        $this->forceR2();
    }

    /**
     * Get the appropriate disk based on configuration
     */
    protected function getDefaultDisk(): string
    {
        if (config('filesystems.default') === 'r2' && $this->isR2Configured()) {
            return 'r2';
        } elseif (config('filesystems.default') === 's3' && $this->isS3Configured()) {
            return 's3';
        } else {
            // Fallback but prefer R2 if possible
            return $this->isR2Configured() ? 'r2' : (config('filesystems.default') ?: 'r2');
        }
    }

    /**
     * Check if R2 is properly configured
     */
    protected function isR2Configured(): bool
    {
        return !empty(config('filesystems.disks.r2.key')) && 
               !empty(config('filesystems.disks.r2.secret')) && 
               !empty(config('filesystems.disks.r2.bucket')) && 
               !empty(config('filesystems.disks.r2.endpoint'));
    }

    /**
     * Check if S3 is properly configured
     */
    protected function isS3Configured(): bool
    {
        return !empty(config('filesystems.disks.s3.key')) && 
               !empty(config('filesystems.disks.s3.secret')) && 
               !empty(config('filesystems.disks.s3.bucket'));
    }

    /**
     * Upload file to storage
     */
    public function upload(UploadedFile $file, string $directory = ''): string
    {
        // Ensure we're using the configured disk
        $disk = $this->defaultDisk;

        // Generate unique filename
        $filename = $this->generateUniqueFilename($file);

        // Convert image to WebP format
        if ($this->isImage($file)) {
            $image = Image::read($file->getRealPath());

            // Convert to WebP with 85% quality
            $webpImage = $image->toWebp(85);

            // Change filename extension to .webp
            $filename = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $filename);

            // Create temporary file for WebP
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            $webpImage->save($tempPath);

            // Upload the WebP file
            $storedPath = Storage::disk($disk)->putFileAs(
                $directory,
                new File($tempPath),
                $filename,
                'public'
            );

            // Clean up temporary file
            @unlink($tempPath);
        } else {
            // For non-image files, upload as is
            $storedPath = Storage::disk($disk)->putFileAs(
                $directory,
                $file,
                $filename,
                'public'
            );
        }

        return $storedPath;
    }

    /**
     * Delete file from storage
     */
    public function delete(string $path): bool
    {
        // Ensure we're using the configured disk
        $disk = $this->defaultDisk;

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return true; // File doesn't exist, so deletion is effectively successful
    }

    /**
     * Get file URL
     */
    public function getUrl(string $path): ?string
    {
        // Ensure we're using the configured disk
        $disk = $this->defaultDisk;

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->url($path);
        }

        return null;
    }

    /**
     * Generate unique filename to prevent conflicts
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = now()->format('YmdHis');
        $randomString = strtolower(Str::random(8));

        // Create unique name combining original name, timestamp, and random string
        $uniqueName = $originalName . '_' . $timestamp . '_' . $randomString;

        // Ensure proper extension
        if ($extension) {
            $uniqueName .= '.' . $extension;
        }

        return $uniqueName;
    }

    /**
     * Force R2 usage for all operations
     */
    public function forceR2(): self
    {
        if ($this->isR2Configured()) {
            $this->defaultDisk = 'r2';
        }
        
        return $this;
    }

    /**
     * Get the current disk being used
     */
    public function getDisk(): string
    {
        return $this->defaultDisk;
    }

    /**
     * Check if file is an image
     */
    protected function isImage(UploadedFile $file): bool
    {
        $mimeType = $file->getMimeType();
        return str_starts_with($mimeType, 'image/');
    }
}