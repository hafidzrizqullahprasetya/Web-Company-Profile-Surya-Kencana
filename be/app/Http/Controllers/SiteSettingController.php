<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Validator;
use App\Services\StorageService;

class SiteSettingController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    /**
     * Display the site settings (singleton).
     */
    public function index()
    {
        try {
            $cacheKey = config(
                "performance.cached_endpoints.site_settings.key",
                "site_settings",
            );
            $cacheTtl = config(
                "performance.cached_endpoints.site_settings.ttl",
                3600,
            );

            $settings = cache()->remember($cacheKey, $cacheTtl, function () {
                return SiteSetting::performanceSelect()->first();
            });

            return response()->json($settings);
        } catch (\Exception $e) {
            \Log::error("Error fetching site settings: " . $e->getMessage());
            return response()->json(
                [
                    "message" => "Error fetching site settings",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Update the site settings (singleton).
     */
    public function update(Request $request)
    {
        // Only validate fields that should be updated, ignore extra fields from response
        $validator = Validator::make($request->all(), [
            "company_name" => "nullable|string|max:255",
            "company_logo" =>
                "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400", // 100MB in KB
            "hero_title" => "nullable|string|max:500",
            "hero_subtitle" => "nullable|string|max:255",
            "visi_misi_label" => "nullable|string|max:255",
            "visi_misi_title" => "nullable|string|max:500",
            "produk_label" => "nullable|string|max:255",
            "produk_title" => "nullable|string|max:500",
            "clients_label" => "nullable|string|max:255",
            "clients_title" => "nullable|string|max:500",
            "riwayat_label" => "nullable|string|max:255",
            "riwayat_title" => "nullable|string|max:500",
            "testimoni_label" => "nullable|string|max:255",
            "testimoni_title" => "nullable|string|max:500",
            "kontak_label" => "nullable|string|max:255",
            "kontak_title" => "nullable|string|max:500",
            // Allow but ignore these fields from API response
            "id" => "nullable",
            "created_at" => "nullable",
            "updated_at" => "nullable",
            "company_logo_url" => "nullable",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => "Validation failed",
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        $settings = SiteSetting::first();

        if (!$settings) {
            $settings = new SiteSetting();
        }

        // Handle logo upload
        if ($request->hasFile("company_logo")) {
            // Delete old logo if exists
            if ($settings->company_logo) {
                $this->storageService->delete($settings->company_logo);
            }

            $settings->company_logo = $this->storageService->upload(
                $request->file("company_logo"),
                "logos",
            );
        }

        // Update text fields
        $textFields = [
            "company_name",
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
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $settings->$field = $request->input($field);
            }
        }

        $settings->save();

        // Clear caches
        cache()->forget(
            config("performance.cached_endpoints.site_settings.key"),
        );
        cache()->forget(
            config("performance.cached_endpoints.landing_page.key"),
        );

        return response()->json([
            "message" => "Settings updated successfully",
            "data" => $settings,
        ]);
    }
}
