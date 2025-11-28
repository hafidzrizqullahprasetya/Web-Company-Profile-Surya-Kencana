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
            $cacheKey = "landing_page_data";
            $cacheDuration = 30; // 30 seconds for faster cache refresh

            $data = cache()->remember($cacheKey, $cacheDuration, function () {
                // Get latest update timestamp from all models
                $lastUpdated = max(
                    Hero::max("updated_at") ?? now(),
                    VisionMission::max("updated_at") ?? now(),
                    Product::max("updated_at") ?? now(),
                    CompanyHistory::max("updated_at") ?? now(),
                    Testimonial::max("updated_at") ?? now(),
                    OurClient::max("updated_at") ?? now(),
                    Contact::max("updated_at") ?? now(),
                    SiteSetting::max("updated_at") ?? now(),
                );

                return [
                    "cacheVersion" => strtotime($lastUpdated), // Unix timestamp untuk cache version
                    "lastUpdated" => $lastUpdated,
                    "hero" => Hero::select(
                        "id",
                        "location",
                        "title",
                        "machines",
                        "clients",
                        "customers",
                        "experience_years",
                        "trust_years",
                        "backgrounds",
                        "updated_at",
                    )->first(),
                    "visionMission" => VisionMission::select(
                        "id",
                        "vision",
                        "mission",
                        "updated_at",
                    )->get(),
                    "products" => Product::with([
                        "client" => function ($query) {
                            $query->select(
                                "id",
                                "client_name",
                                "institution",
                                "logo_path",
                            );
                        },
                    ])
                        ->select(
                            "id",
                            "client_id",
                            "name",
                            "description",
                            "image_path",
                            "price",
                            "images",
                            "created_at",
                            "updated_at",
                        )
                        ->orderBy("created_at", "desc")
                        ->get(),
                    "companyHistory" => CompanyHistory::select(
                        "id",
                        "tahun",
                        "judul",
                        "deskripsi",
                        "image_path",
                        "images",
                        "created_at",
                        "updated_at",
                    )
                        ->orderBy("tahun", "desc")
                        ->get(),
                    "testimonials" => Testimonial::select(
                        "id",
                        "client_name",
                        "institution",
                        "feedback",
                        "date",
                        "created_at",
                        "updated_at",
                    )
                        ->orderBy("date", "desc")
                        ->limit(10)
                        ->get(),
                    "clients" => OurClient::select(
                        "id",
                        "client_name",
                        "institution",
                        "logo_path",
                        "created_at",
                        "updated_at",
                    )
                        ->orderBy("client_name", "asc")
                        ->get(),
                    "contact" => Contact::select(
                        "id",
                        "phone",
                        "email",
                        "address",
                        "map_url",
                        "updated_at",
                    )->first(),
                    "siteSettings" => SiteSetting::select(
                        "id",
                        "company_name",
                        "company_logo", // Will include company_logo_url via appends
                        "hero_title",
                        "hero_subtitle",
                        "visi_misi_label",
                        "visi_misi_title",
                        "produk_label",
                        "produk_title",
                        "clients_label",
                        "clients_title",
                        "riwayat_label",
                        "riwayat_title",
                        "testimoni_label",
                        "testimoni_title",
                        "kontak_label",
                        "kontak_title",
                        "updated_at",
                    )->first(),
                ];
            });

            return response()
                ->json($data, 200)
                ->header("Cache-Control", "public, max-age=30");
        } catch (\Exception $e) {
            Log::error("Error fetching landing page data: " . $e->getMessage());

            return response()->json(
                [
                    "message" => "Failed to fetch landing page data",
                    "error" => $e->getMessage(),
                ],
                500,
            );
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
            cache()->forget(
                config(
                    "performance.cached_endpoints.landing_page.key",
                    "landing_page",
                ),
            );

            return response()->json(
                [
                    "message" => "Landing page cache cleared successfully",
                ],
                200,
            );
        } catch (\Exception $e) {
            Log::error(
                "Error clearing landing page cache: " . $e->getMessage(),
            );

            return response()->json(
                [
                    "message" => "Failed to clear cache",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
