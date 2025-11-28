<?php

namespace App\Traits;

use App\Services\ImageCacheService;
use Illuminate\Support\Facades\Storage;

trait StorageImageTrait
{
    /**
     * Build image URL dari path
     * Note: File existence check is now handled via cached approach to improve performance
     *
     * @param string|null $path
     * @param bool $checkExists - Parameter kept for compatibility but not used in this optimized version
     * @return string|null
     */
    public function buildImageUrl(
        ?string $path,
        bool $checkExists = false,
    ): ?string {
        // Use the ImageCacheService to build the URL
        $imageCacheService = app(ImageCacheService::class);
        return $imageCacheService->buildImageUrl($path, false); // Always use false for performance
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
        return ["image_path", "logo_path", "background", "company_logo"];
    }
}
