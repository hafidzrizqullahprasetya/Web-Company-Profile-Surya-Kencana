<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OurClient;
use App\Models\Testimonial;
use App\Models\Admin;

/**
 * @OA\Tag(
 *     name="Dashboard",
 *     description="API Endpoints untuk dashboard summary"
 * )
 */
class DashboardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dashboard",
     *     summary="Ambil data dashboard summary",
     *     description="Mendapatkan statistik summary dan data terbaru untuk dashboard",
     *     operationId="getDashboard",
     *     tags={"Dashboard"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data dashboard",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="summary",
     *                 type="object",
     *                 @OA\Property(property="total_products", type="integer", example=10),
     *                 @OA\Property(property="total_clients", type="integer", example=5),
     *                 @OA\Property(property="total_testimony", type="integer", example=8),
     *                 @OA\Property(property="total_admins", type="integer", example=2)
     *             ),
     *             @OA\Property(
     *                 property="recent_products",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             ),
     *             @OA\Property(
     *                 property="recent_testimonials",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            // Get summary counts
            $summary = [
                'total_products' => Product::count(),
                'total_clients' => OurClient::count(),
                'total_testimony' => Testimonial::count(),
                'total_admins' => Admin::count(),
            ];

            // Get recent products (latest 5)
            $recentProducts = Product::performanceSelect()
                ->with([
                    'client' => function ($query) {
                        $query->select('id', 'client_name', 'institution', 'logo_path');
                    },
                ])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Get recent testimonials (latest 5)
            $recentTestimonials = Testimonial::performanceSelect()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'summary' => $summary,
                'recent_products' => $recentProducts,
                'recent_testimonials' => $recentTestimonials,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching dashboard data: ' . $e->getMessage());
            return response()->json(
                [
                    'message' => 'Error fetching dashboard data',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }
}
