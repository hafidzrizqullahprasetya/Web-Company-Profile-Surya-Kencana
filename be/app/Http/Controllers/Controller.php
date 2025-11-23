<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Backend Compro API Documentation",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk Backend Company Profile Surya Kencana
 * ## Fitur Utama
 * **Authentication** - Login dan logout untuk admin/super admin
 * **Products** - Manajemen produk dengan upload gambar
 * **Vision & Mission** - Manajemen visi dan misi perusahaan
 * **Clients** - Manajemen data client/partner dengan upload logo
 * **Testimonials** - Manajemen testimoni pelanggan
 * **Contact** - Manajemen informasi kontak perusahaan
 * **Admin Management** - Manajemen akun admin (hanya super admin)
 * ## Cara Menggunakan
 * **Langkah 1:** Login melalui endpoint POST `/api/login`
 * **Langkah 2:** Copy token dari response JSON
 * **Langkah 3:** Klik tombol **Authorize** (gembok hijau di atas)
 * **Langkah 4:** Paste token dengan format `Bearer {your-token}`
 * **Langkah 5:** Klik Authorize dan Close
 * **Langkah 6:** Sekarang Anda bisa akses endpoint yang memerlukan autentikasi",
 *
 *     @OA\Contact(
 *         email="support@suryakencana.com",
 *         name="API Support"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Alternative Local Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token Bearer yang didapat dari endpoint /api/login. Format: Bearer {your-token}"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoint untuk login dan logout admin/super admin"
 * )
 *
 * @OA\Tag(
 *     name="Admin Management",
 *     description="Manajemen akun admin. Semua endpoint memerlukan autentikasi super admin"
 * )
 *
 * @OA\Tag(
 *     name="Products",
 *     description="CRUD produk dengan upload gambar. GET public, POST/PUT/DELETE memerlukan autentikasi"
 * )
 *
 * @OA\Tag(
 *     name="Vision & Mission",
 *     description="Manajemen visi dan misi perusahaan. GET public, PUT memerlukan autentikasi"
 * )
 *
 * @OA\Tag(
 *     name="Clients",
 *     description="Manajemen data client/partner perusahaan dengan upload logo. GET public, POST/PUT/DELETE memerlukan autentikasi"
 * )
 *
 * @OA\Tag(
 *     name="Testimonials",
 *     description="Manajemen testimoni dari client. GET public, POST/PUT/DELETE memerlukan autentikasi"
 * )
 *
 * @OA\Tag(
 *     name="Contact",
 *     description="Manajemen informasi kontak perusahaan. GET public, PUT memerlukan autentikasi"
 * )
 */
abstract class Controller
{
    //
}
