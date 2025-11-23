<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\VisionMission;
use App\Models\Product;
use App\Models\CompanyHistory;
use App\Models\Testimonial;
use App\Models\OurClient;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    /**
     * Get all landing page data in one request
     *
     * Optimized with:
     * - Cache for 5 minutes
     * - Selected fields only
     * - Minimal queries
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $cacheKey = 'landing_page_data';
            $cacheDuration = 30; // 30 seconds for faster cache refresh

            $data = cache()->remember($cacheKey, $cacheDuration, function () {
                // Get latest update timestamp from all models
                $lastUpdated = max(
                    Hero::max('updated_at') ?? now(),
                    VisionMission::max('updated_at') ?? now(),
                    Product::max('updated_at') ?? now(),
                    CompanyHistory::max('updated_at') ?? now(),
                    Testimonial::max('updated_at') ?? now(),
                    OurClient::max('updated_at') ?? now(),
                    Contact::max('updated_at') ?? now(),
                    SiteSetting::max('updated_at') ?? now()
                );

                return [
                    'cacheVersion' => strtotime($lastUpdated), // Unix timestamp untuk cache version
                    'lastUpdated' => $lastUpdated,
                    'hero' => Hero::first(),
                    'visionMission' => VisionMission::all(),
                    'products' => Product::all(),
                    'companyHistory' => CompanyHistory::orderBy('tahun', 'desc')->get(),
                    'testimonials' => Testimonial::orderBy('date', 'desc')->get(),
                    'clients' => OurClient::all(),
                    'contact' => Contact::first(),
                    'siteSettings' => SiteSetting::first(),
                ];
            });

            return response()
                ->json($data, 200)
                ->header('Cache-Control', 'public, max-age=30'); 
        } catch (\Exception $e) {
            Log::error('Error fetching landing page data: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch landing page data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear landing page cache
     * Dipanggil setiap kali ada update data dari admin panel
     *
     * @return JsonResponse
     */
    public function clearCache(): JsonResponse
    {
        try {
            cache()->forget('landing_page_data');

            return response()->json([
                'message' => 'Landing page cache cleared successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error clearing landing page cache: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
