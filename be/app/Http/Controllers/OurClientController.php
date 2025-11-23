<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OurClient;
use App\Services\StorageService;

class OurClientController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    /**
     * @OA\Get(
     *     path="/api/our-client",
     *     summary="Ambil semua data client",
     *     description="Mendapatkan daftar semua client/partner perusahaan beserta logo mereka",
     *     operationId="getClients",
     *     tags={"Clients"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data client",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="PT ABC Technology"),
     *                 @OA\Property(property="institution", type="string", example="Technology Company"),
     *                 @OA\Property(property="logo_path", type="string", example="ourClients/abc123.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clients = OurClient::all();
        return response()->json($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/our-client/{id}",
     *     summary="Ambil detail client berdasarkan ID",
     *     description="Mendapatkan informasi detail client berdasarkan ID yang diberikan",
     *     operationId="getClientById",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID client yang ingin diambil",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data client",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="client_name", type="string", example="PT ABC Technology"),
     *             @OA\Property(property="institution", type="string", example="Technology Company"),
     *             @OA\Property(property="logo_path", type="string", example="ourClients/abc123.jpg"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $client = OurClient::find($id);
        if ($client) {
            return response()->json($client);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/our-client",
     *     summary="Tambah client baru",
     *     description="Membuat client baru dengan upload logo. Endpoint ini memerlukan autentikasi.",
     *     operationId="storeClient",
     *     tags={"Clients"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data client yang akan dibuat (multipart/form-data)",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"client_name", "institution", "logo_path"},
     *                 @OA\Property(
     *                     property="client_name",
     *                     type="string",
     *                     description="Nama client/partner",
     *                     example="PT ABC Technology"
     *                 ),
     *                 @OA\Property(
     *                     property="institution",
     *                     type="string",
     *                     description="Nama institusi/jenis perusahaan",
     *                     example="Technology Company"
     *                 ),
     *                 @OA\Property(
     *                     property="logo_path",
     *                     type="string",
     *                     format="binary",
     *                     description="File logo client (jpeg, png, jpg, gif, svg, max 5MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="PT ABC Technology"),
     *                 @OA\Property(property="institution", type="string", example="Technology Company"),
     *                 @OA\Property(property="logo_path", type="string", example="ourClients/abc123.jpg"),
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
            'logo_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400' // 100MB in KB
        ]);

        // Upload logo using StorageService
        $logoPath = $this->storageService->upload($request->file('logo_path'), 'ourClients');

        $client = OurClient::create([
            'client_name' => $request->client_name,
            'institution' => $request->institution,
            'logo_path' => $logoPath,
        ]);

        return response()->json([
            'message' => 'Client created successfully',
            'data' => $client
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/our-client/{id}",
     *     summary="Update client yang sudah ada",
     *     description="Mengupdate data client berdasarkan ID. Endpoint ini memerlukan autentikasi.",
     *     operationId="updateClient",
     *     tags={"Clients"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID client yang akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data client yang akan diupdate (multipart/form-data). Tambahkan _method=PUT untuk Laravel.",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"_method", "client_name", "institution", "logo_path"},
     *                 @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     description="Method spoofing untuk Laravel (PUT)",
     *                     example="PUT"
     *                 ),
     *                 @OA\Property(
     *                     property="client_name",
     *                     type="string",
     *                     description="Nama client/partner",
     *                     example="PT ABC Technology Updated"
     *                 ),
     *                 @OA\Property(
     *                     property="institution",
     *                     type="string",
     *                     description="Nama institusi/jenis perusahaan",
     *                     example="IT Solutions Company"
     *                 ),
     *                 @OA\Property(
     *                     property="logo_path",
     *                     type="string",
     *                     format="binary",
     *                     description="File logo baru (jpeg, png, jpg, gif, svg, max 5MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="PT ABC Technology Updated"),
     *                 @OA\Property(property="institution", type="string", example="IT Solutions Company"),
     *                 @OA\Property(property="logo_path", type="string", example="ourClients/new123.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
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
        $client = OurClient::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'logo_path' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400' // 100MB in KB
        ]);

        if ($request->hasFile('logo_path')) {
            if ($client->logo_path) {
                // Delete old logo from storage
                $this->storageService->delete($client->logo_path);
            }
            $client->logo_path = $this->storageService->upload($request->file('logo_path'), 'ourClients');
        }

        $updateData = $request->only(['client_name', 'institution']);
        $client->fill($updateData);
        $client->save();

        return response()->json([
            'message' => 'Client updated successfully',
            'data' => $client->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/our-client/{id}",
     *     summary="Hapus client",
     *     description="Menghapus client berdasarkan ID. File logo yang terkait juga akan dihapus. Endpoint ini memerlukan autentikasi.",
     *     operationId="deleteClient",
     *     tags={"Clients"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID client yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
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
        $client = OurClient::find($id);
        if ($client) {
            // Delete logo from storage if exists
            if ($client->logo_path) {
                $this->storageService->delete($client->logo_path);
            }

            $client->delete();
            return response()->json(['message' => 'Client deleted successfully']);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }
}
