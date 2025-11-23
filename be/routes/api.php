<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OurClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CompanyHistoryController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| File ini berisi definisi seluruh endpoint API untuk aplikasi ini.
| Setiap route diatur agar dapat diakses baik oleh publik maupun
| hanya oleh user yang telah terautentikasi menggunakan Sanctum.
|
| Struktur utama:
| - Public Routes: dapat diakses tanpa login
| - Protected Routes: hanya dapat diakses dengan token login (auth:sanctum)
|
*/

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Digunakan untuk proses login dan logout admin/superadmin.
|
| POST /login         -> Login untuk admin dan superadmin
| POST /logout        -> Logout (memerlukan token)
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Landing Page Route (Combined Data)
|--------------------------------------------------------------------------
| New endpoint untuk mendapatkan semua data landing page dalam satu request.
| Ini akan meningkatkan performa dengan mengurangi jumlah HTTP requests.
|
| GET /landing-page     -> Menampilkan semua data landing page (public)
|
*/
Route::get('/landing-page', [LandingPageController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Vision & Mission Routes
|--------------------------------------------------------------------------
| Menampilkan dan mengubah visi misi perusahaan.
|
| GET /vision-mission       -> Menampilkan data visi misi (public)
| PUT /vision-mission       -> Mengupdate data visi misi (auth:sanctum)
|
*/
Route::get('/vision-mission', [VisionMissionController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
| Menangani data produk (list, detail, tambah, ubah, hapus).
|
| GET /product              -> Menampilkan seluruh produk
| GET /product/{id}         -> Menampilkan detail produk berdasarkan ID
| POST /product             -> Menambahkan produk baru (auth:sanctum)
| PUT /product/{id}         -> Mengupdate produk berdasarkan ID (auth:sanctum)
| DELETE /product/{id}      -> Menghapus produk berdasarkan ID (auth:sanctum)
|
*/
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Our Client Routes
|--------------------------------------------------------------------------
| Menampilkan dan mengelola data klien perusahaan.
|
| GET /our-client           -> Menampilkan seluruh klien
| GET /our-client/{id}      -> Menampilkan detail klien
| POST /our-client          -> Menambahkan klien baru (auth:sanctum)
| PUT /our-client/{id}      -> Mengupdate klien (auth:sanctum)
| DELETE /our-client/{id}   -> Menghapus klien (auth:sanctum)
|
*/
Route::get('/our-client', [OurClientController::class, 'index']);
Route::get('/our-client/{id}', [OurClientController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
| Mengatur data kontak perusahaan.
|
| GET /contact              -> Menampilkan data kontak (public)
| PUT /contact              -> Mengupdate data kontak (auth:sanctum)
|
*/
Route::get('/contact', [ContactController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Testimonial Routes
|--------------------------------------------------------------------------
| Menangani data testimoni dari klien/pengguna.
|
| GET /testimonial          -> Menampilkan seluruh testimoni (public)
| POST /testimonial         -> Menambahkan testimoni baru (auth:sanctum)
| PUT /testimonial/{id}     -> Mengupdate testimoni (auth:sanctum)
| DELETE /testimonial/{id}  -> Menghapus testimoni (auth:sanctum)
|
*/
Route::get('/testimonial', [TestimonialController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Hero Routes
|--------------------------------------------------------------------------
| Mengelola data hero section (singleton pattern).
|
| GET /hero                 -> Menampilkan data hero section (public)
| PUT /hero                 -> Mengupdate hero section (auth:sanctum)
|
*/
Route::get('/hero', [HeroController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Company History Routes
|--------------------------------------------------------------------------
| Menampilkan dan mengelola riwayat perusahaan.
|
| GET /company-history          -> Menampilkan seluruh riwayat (public)
| GET /company-history/{id}     -> Menampilkan detail riwayat
| POST /company-history         -> Menambahkan riwayat baru (auth:sanctum)
| PUT /company-history/{id}     -> Mengupdate riwayat (auth:sanctum)
| DELETE /company-history/{id}  -> Menghapus riwayat (auth:sanctum)
|
*/
Route::get('/company-history', [CompanyHistoryController::class, 'index']);
Route::get('/company-history/{id}', [CompanyHistoryController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Site Settings Routes
|--------------------------------------------------------------------------
| Mengelola pengaturan situs (nama perusahaan, logo, judul section).
|
| GET /site-settings           -> Menampilkan pengaturan situs (public)
| PUT /site-settings           -> Mengupdate pengaturan situs (auth:sanctum)
|
*/
Route::get('/site-settings', [SiteSettingController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:sanctum)
|--------------------------------------------------------------------------
| Seluruh route di bawah grup ini hanya bisa diakses setelah login.
| Token yang valid harus dikirimkan melalui header:
| Authorization: Bearer {token}
|
*/
Route::middleware('auth:sanctum')->group(function () {
    // Vision and Mission Routes
    Route::put('/vision-mission', [VisionMissionController::class, 'update']);

    // Contact Routes
    Route::put('/contact', [ContactController::class, 'update']);

    // Admin Routes
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/{id}', [AdminController::class, 'show']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::put('/admin/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy']);

    // Product Routes
    Route::post('/product', [ProductController::class, 'store']);
    Route::post('/product/{id}', [ProductController::class, 'update']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    // Client Routes
    Route::post('/our-client', [OurClientController::class, 'store']);
    Route::post('/our-client/{id}', [OurClientController::class, 'update']);
    Route::put('/our-client/{id}', [OurClientController::class, 'update']);
    Route::delete('/our-client/{id}', [OurClientController::class, 'destroy']);

    // Testimonial Routes
    Route::post('/testimonial', [TestimonialController::class, 'store']);
    Route::put('/testimonial/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonial/{id}', [TestimonialController::class, 'destroy']);

    // Hero Routes
    Route::post('/hero', [HeroController::class, 'update']); // For multipart/form-data
    Route::put('/hero', [HeroController::class, 'update']);

    // Company History Routes
    Route::post('/company-history', [CompanyHistoryController::class, 'store']);
    Route::put('/company-history/{id}', [CompanyHistoryController::class, 'update']);
    Route::delete('/company-history/{id}', [CompanyHistoryController::class, 'destroy']);

    // Site Settings Routes
    Route::post('/site-settings', [SiteSettingController::class, 'update']); // For multipart/form-data
    Route::put('/site-settings', [SiteSettingController::class, 'update']);
});
