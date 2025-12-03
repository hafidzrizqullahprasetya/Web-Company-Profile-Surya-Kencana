<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Hero;
use App\Models\VisionMission;
use App\Models\Product;
use App\Models\CompanyHistory;
use App\Models\Testimonial;
use App\Models\OurClient;
use App\Models\Contact;
use App\Models\SiteSetting;

class LandingPageController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = [
                "cacheVersion" => 0,
                "lastUpdated" => now()->toIso8601String(),
                "hero" => Hero::performanceSelect()->first(),
                "visionMission" => VisionMission::performanceSelect()->get(),
                "products" => Product::performanceSelect()->orderBy('order')->get(),
                "companyHistory" => CompanyHistory::performanceSelect()->orderBy('tahun')->get(),
                "testimonials" => Testimonial::performanceSelect()->orderBy('order')->get(),
                "clients" => OurClient::performanceSelect()->orderBy('order')->get(),
                "contact" => Contact::performanceSelect()->first(),
                "siteSettings" => SiteSetting::performanceSelect()->first(),
            ];

            return response()->json($data, 200)
                ->header("Cache-Control", "no-cache, no-store, must-revalidate");
        } catch (\Exception $e) {
            \Log::error("Error fetching landing page data: " . $e->getMessage());

            return response()->json([
                "cacheVersion" => 0,
                "lastUpdated" => now()->toIso8601String(),
                "hero" => null,
                "visionMission" => [],
                "products" => [],
                "companyHistory" => [],
                "testimonials" => [],
                "clients" => [],
                "contact" => null,
                "siteSettings" => null,
            ], 200)
                ->header("Cache-Control", "no-cache, no-store, must-revalidate");
        }
    }
}
