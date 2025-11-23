<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vision-mission",
     *     summary="Ambil data visi dan misi",
     *     description="Mendapatkan data visi dan misi perusahaan. Endpoint public, tidak memerlukan autentikasi.",
     *     operationId="getVisionMission",
     *     tags={"Vision & Mission"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data visi dan misi",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="vision", type="string", example="Menjadi perusahaan teknologi terdepan di Indonesia"),
     *                 @OA\Property(property="mission", type="string", example="Memberikan solusi teknologi terbaik dengan kualitas internasional"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-24T10:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-24T10:00:00.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $visionMissions = VisionMission::all();
        return response()->json($visionMissions);
    }

    /**
     * @OA\Put(
     *     path="/api/vision-mission",
     *     summary="Update visi dan misi",
     *     description="Mengupdate data visi dan misi perusahaan. Endpoint ini memerlukan autentikasi.",
     *     operationId="updateVisionMission",
     *     tags={"Vision & Mission"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=false,
     *         description="Data visi dan misi yang akan diupdate (semua field opsional)",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="vision",
     *                     type="string",
     *                     description="Visi perusahaan (opsional)",
     *                     example="Menjadi perusahaan teknologi terdepan di Asia Tenggara"
     *                 ),
     *                 @OA\Property(
     *                     property="mission",
     *                     type="string",
     *                     description="Misi perusahaan (opsional)",
     *                     example="1. Memberikan solusi teknologi terbaik\n2. Meningkatkan kualitas SDM\n3. Berinovasi secara berkelanjutan"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visi dan misi berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Vision and Mission updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="vision", type="string", example="Menjadi perusahaan teknologi terdepan di Asia Tenggara"),
     *                 @OA\Property(property="mission", type="string", example="1. Memberikan solusi teknologi terbaik\n2. Meningkatkan kualitas SDM"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data visi dan misi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Vision and Mission not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="vision",
     *                     type="array",
     *                     @OA\Items(type="string", example="The vision field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token tidak valid atau tidak ada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        $request->validate([
            'vision' => 'sometimes|required|string',
            'mission' => 'sometimes|required|string',
        ]);

        $visionMission = VisionMission::first();
        if ($visionMission) {
            $visionMission->update($request->all());

            // Clear landing page cache
            cache()->forget('landing_page_data');

            return response()->json([
                "message" => "Vision and Mission updated successfully",
                "data" => $visionMission
            ]);
        } else {
            return response()->json(['message' => 'Vision and Mission not found'], 404);
        }
    }
}
