<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/testimonial",
     *     summary="Ambil semua data testimoni",
     *     description="Mendapatkan daftar semua testimoni dari client",
     *     operationId="getTestimonials",
     *     tags={"Testimonials"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data testimoni",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="John Doe"),
     *                 @OA\Property(property="institution", type="string", example="PT ABC Technology"),
     *                 @OA\Property(property="feedback", type="string", example="Pelayanan sangat memuaskan dan profesional"),
     *                 @OA\Property(property="date", type="string", format="date", example="2025-10-15"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $testimonial = Testimonial::all();
        return response()->json($testimonial);
    }

    /**
     * @OA\Post(
     *     path="/api/testimonial",
     *     summary="Tambah testimoni baru",
     *     description="Membuat testimoni baru dari client. Endpoint ini memerlukan autentikasi.",
     *     operationId="storeTestimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data testimoni yang akan dibuat",
     *         @OA\JsonContent(
     *             required={"client_name", "institution", "feedback", "date"},
     *             @OA\Property(
     *                 property="client_name",
     *                 type="string",
     *                 description="Nama client yang memberikan testimoni",
     *                 example="John Doe"
     *             ),
     *             @OA\Property(
     *                 property="institution",
     *                 type="string",
     *                 description="Nama institusi/perusahaan client",
     *                 example="PT ABC Technology"
     *             ),
     *             @OA\Property(
     *                 property="feedback",
     *                 type="string",
     *                 description="Isi testimoni/feedback dari client",
     *                 example="Pelayanan sangat memuaskan dan profesional. Tim sangat responsif dan hasil kerja berkualitas tinggi."
     *             ),
     *             @OA\Property(
     *                 property="date",
     *                 type="string",
     *                 format="date",
     *                 description="Tanggal testimoni diberikan (YYYY-MM-DD)",
     *                 example="2025-10-15"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Testimoni berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonial created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="John Doe"),
     *                 @OA\Property(property="institution", type="string", example="PT ABC Technology"),
     *                 @OA\Property(property="feedback", type="string", example="Pelayanan sangat memuaskan dan profesional"),
     *                 @OA\Property(property="date", type="string", format="date", example="2025-10-15"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
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
     *                     property="client_name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The client name field is required.")
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
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'feedback' => 'required|string',
            'date' => 'required|date',
        ]);

        $testimonial = Testimonial::create($request->all());

        // Clear landing page cache
        cache()->forget('landing_page_data');

        return response()->json([
            "message" => "Testimonial created successfully",
            "data" => $testimonial
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/testimonial/{id}",
     *     summary="Update testimoni",
     *     description="Mengupdate data testimoni berdasarkan ID. Endpoint ini memerlukan autentikasi.",
     *     operationId="updateTestimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID testimoni yang akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data testimoni yang akan diupdate",
     *         @OA\JsonContent(
     *             required={"client_name", "institution", "feedback", "date"},
     *             @OA\Property(property="client_name", type="string", example="John Doe Updated"),
     *             @OA\Property(property="institution", type="string", example="PT ABC Technology"),
     *             @OA\Property(property="feedback", type="string", example="Pelayanan sangat memuaskan"),
     *             @OA\Property(property="date", type="string", format="date", example="2025-10-20")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Testimoni berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonial updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="John Doe Updated"),
     *                 @OA\Property(property="institution", type="string", example="PT ABC Technology"),
     *                 @OA\Property(property="feedback", type="string", example="Pelayanan sangat memuaskan"),
     *                 @OA\Property(property="date", type="string", format="date", example="2025-10-20")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimoni tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonial not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'feedback' => 'required|string',
            'date' => 'required|date',
        ]);

        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->update($request->all());

            // Clear landing page cache
            cache()->forget('landing_page_data');

            return response()->json([
                "message" => "Testimonial updated successfully",
                "data" => $testimonial
            ]);
        } else {
            return response()->json(['message' => 'Testimonial not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/testimonial/{id}",
     *     summary="Hapus testimoni",
     *     description="Menghapus testimoni berdasarkan ID. Endpoint ini memerlukan autentikasi.",
     *     operationId="deleteTestimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID testimoni yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Testimoni berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonial deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimoni tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Testimonial not found")
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
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->delete();

            // Clear landing page cache
            cache()->forget('landing_page_data');

            return response()->json(['message' => 'Testimonial deleted successfully']);
        } else {
            return response()->json(['message' => 'Testimonial not found'], 404);
        }
    }
}
