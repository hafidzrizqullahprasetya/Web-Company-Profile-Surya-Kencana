<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin",
     *     summary="Ambil semua data admin",
     *     description="Mendapatkan daftar semua admin yang terdaftar. Endpoint ini memerlukan autentikasi.",
     *     operationId="getAllAdmins",
     *     tags={"Admin Management"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data admin",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="admin1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
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
    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    /**
     * @OA\Post(
     *     path="/api/admin",
     *     summary="Tambah admin baru",
     *     description="Membuat akun admin baru. Endpoint ini memerlukan autentikasi (hanya super admin).",
     *     operationId="storeAdmin",
     *     tags={"Admin Management"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data admin yang akan dibuat",
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(
     *                 property="username",
     *                 type="string",
     *                 description="Username admin (max 255 karakter)",
     *                 example="admin_baru"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="Password admin (minimal 6 karakter, max 255 karakter)",
     *                 example="password123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Admin berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="admin_baru"),
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
     *                     property="username",
     *                     type="array",
     *                     @OA\Items(type="string", example="The username field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="array",
     *                     @OA\Items(type="string", example="The password must be at least 6 characters.")
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
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $Admin = Admin::create($request->all());
        return response()->json([
            "message" => "Admin created successfully",
            "data" => $Admin
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/{id}",
     *     summary="Update data admin",
     *     description="Mengupdate data admin berdasarkan ID. Endpoint ini memerlukan autentikasi (hanya super admin).",
     *     operationId="updateAdmin",
     *     tags={"Admin Management"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID admin yang akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data admin yang akan diupdate",
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(
     *                 property="username",
     *                 type="string",
     *                 description="Username admin (max 255 karakter)",
     *                 example="admin_updated"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="Password admin (minimal 6 karakter, max 255 karakter)",
     *                 example="newpassword123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="admin_updated"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin not found")
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
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $Admin = Admin::find($id);
        if ($Admin) {
            $Admin->update($request->all());
            return response()->json([
                "message" => "Admin updated successfully",
                "data" => $Admin
            ]);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/{id}",
     *     summary="Hapus admin",
     *     description="Menghapus akun admin berdasarkan ID. Endpoint ini memerlukan autentikasi (hanya super admin).",
     *     operationId="deleteAdmin",
     *     tags={"Admin Management"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID admin yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin not found")
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
        $Admin = Admin::find($id);
        if ($Admin) {
            $Admin->delete();
            return response()->json(['message' => 'Admin deleted successfully']);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }
}
