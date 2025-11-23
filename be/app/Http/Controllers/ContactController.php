<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/contact",
     *     summary="Ambil informasi kontak",
     *     description="Mendapatkan informasi kontak perusahaan (alamat, telepon, email, map URL)",
     *     operationId="getContact",
     *     tags={"Contact"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data kontak",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="address", type="string", example="Jl. Sudirman No. 123, Jakarta"),
     *                 @OA\Property(property="phone", type="string", example="+62 21 1234567"),
     *                 @OA\Property(property="email", type="string", format="email", example="contact@suryakencana.com"),
     *                 @OA\Property(property="map_url", type="string", format="url", example="https://maps.google.com/?q=-6.2088,106.8456"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $contact = Contact::all();
        return response()->json($contact);
    }

    /**
     * @OA\Put(
     *     path="/api/contact",
     *     summary="Update informasi kontak",
     *     description="Mengupdate informasi kontak perusahaan. Semua field bersifat opsional. Endpoint ini memerlukan autentikasi.",
     *     operationId="updateContact",
     *     tags={"Contact"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data kontak yang akan diupdate (semua field opsional)",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="address",
     *                 type="string",
     *                 description="Alamat lengkap perusahaan",
     *                 example="Jl. Sudirman No. 123, Jakarta Pusat 10220"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 description="Nomor telepon perusahaan",
     *                 example="+62 21 1234567"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="Email perusahaan",
     *                 example="contact@suryakencana.com"
     *             ),
     *             @OA\Property(
     *                 property="map_url",
     *                 type="string",
     *                 format="url",
     *                 description="URL Google Maps lokasi perusahaan",
     *                 example="https://maps.google.com/?q=-6.2088,106.8456"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kontak berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="address", type="string", example="Jl. Sudirman No. 123, Jakarta Pusat 10220"),
     *                 @OA\Property(property="phone", type="string", example="+62 21 1234567"),
     *                 @OA\Property(property="email", type="string", example="contact@suryakencana.com"),
     *                 @OA\Property(property="map_url", type="string", example="https://maps.google.com/?q=-6.2088,106.8456"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data kontak tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact not found")
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
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email must be a valid email address.")
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
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'map_url' => 'sometimes|required|url',
        ]);

        $contact = Contact::first();
        if ($contact) {
            $contact->update($request->all());

            // Clear landing page cache
            cache()->forget('landing_page_data');

            return response()->json([
                "message" => "Contact updated successfully",
                "data" => $contact
            ]);
        } else {
            return response()->json(['message' => 'Contact not found'], 404);
        }
    }
}
