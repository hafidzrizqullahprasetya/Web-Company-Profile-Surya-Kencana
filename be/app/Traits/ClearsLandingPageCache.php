<?php

namespace App\Traits;

/**
 * Trait ClearsLandingPageCache
 *
 * Automatically clears landing page cache when model is saved or deleted
 *
 * Usage: Add this trait to models that are part of landing page data:
 * - Hero
 * - VisionMission
 * - Product
 * - CompanyHistory
 * - Testimonial
 * - OurClient
 * - Contact
 * - SiteSetting
 */
trait ClearsLandingPageCache
{
    /**
     * Boot the trait
     */
    protected static function bootClearsLandingPageCache()
    {
        // Clear cache after creating
        static::created(function () {
            cache()->forget('landing_page_data');
        });

        // Clear cache after updating
        static::updated(function () {
            cache()->forget('landing_page_data');
        });

        // Clear cache after deleting
        static::deleted(function () {
            cache()->forget('landing_page_data');
        });
    }
}
