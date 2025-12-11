<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints untuk autentikasi admin dan super admin"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login admin atau super admin",
     *     description="Endpoint untuk login dan mendapatkan authentication token. Support untuk Admin dan Super Admin.",
     *     operationId="login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Kredensial login",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"username", "password"},
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     description="Username admin atau super admin",
     *                     example="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     description="Password (minimal 6 karakter)",
     *                     example="admin123"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="1|abcdefghijklmnopqrstuvwxyz1234567890",
     *                 description="Bearer token untuk autentikasi"
     *             ),
     *             @OA\Property(
     *                 property="admin",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="admin")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Username atau password salah",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid username or password")
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
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        // Detect device type from request header or default to 'web'
        $deviceType = $request->header('X-Device-Type', 'web'); // Android should send 'mobile'
        $tokenName = $deviceType === 'mobile' ? 'mobile_token' : 'web_token';

        // Use a single query to check both admin and superadmin tables
        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Only delete OLD tokens with the SAME device type (keep other device types)
            // This allows user to be logged in on both web and mobile simultaneously
            $admin->tokens()->where('name', $tokenName)->delete();
            $token = $admin->createToken($tokenName)->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'admin' => [
                    'id' => $admin->id,
                    'username' => $admin->username,
                    'role' => 'admin'
                ]
            ]);
        }

        $superadmin = SuperAdmin::where('username', $request->username)->first();
        if ($superadmin && Hash::check($request->password, $superadmin->password)) {
            // Only delete OLD tokens with the SAME device type (keep other device types)
            // This allows user to be logged in on both web and mobile simultaneously
            $superadmin->tokens()->where('name', $tokenName)->delete();
            $token = $superadmin->createToken($tokenName)->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'admin' => [
                    'id' => $superadmin->id,
                    'username' => $superadmin->username,
                    'role' => 'superadmin'
                ]
            ]);
        }

        return response()->json(['message' => 'Invalid username or password'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout dan hapus token",
     *     description="Endpoint untuk logout dan menghapus token autentikasi yang sedang aktif. Memerlukan autentikasi.",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token tidak valid, tidak ditemukan, atau sudah tidak aktif",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Unauthenticated.")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="No active token found")
     *                 )
     *             }
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        /** @var \Laravel\Sanctum\PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
            return response()->json(['message' => 'Logout successful']);
        }

        return response()->json(['message' => 'No active token found'], 401);
    }
}
