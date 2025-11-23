<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\StorageService;

/**
 * @OA\Tag(
 *     name="Product",
 *     description="API Endpoints untuk manajemen produk"
 * )
 */
class ProductController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    /**
     * @OA\Get(
     *     path="/api/product",
     *     summary="Ambil semua data produk",
     *     description="Mendapatkan daftar semua produk beserta data client yang terkait",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data produk",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="E-commerce Platform"),
     *                 @OA\Property(property="description", type="string", example="Website e-commerce dengan fitur lengkap"),
     *                 @OA\Property(property="price", type="number", format="float", example=25000000),
     *                 @OA\Property(property="image_path", type="string", example="products/abc123.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-24T10:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-24T10:00:00.000000Z"),
     *                 @OA\Property(
     *                     property="client",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="client_name", type="string", example="PT ABC Technology"),
     *                     @OA\Property(property="institution", type="string", example="Technology Company"),
     *                     @OA\Property(property="logo_path", type="string", example="client_logos/xyz.png")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $products = Product::with('client')->get();
        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *     summary="Ambil detail produk berdasarkan ID",
     *     description="Mendapatkan informasi detail produk berdasarkan ID yang diberikan",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID produk yang ingin diambil",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data produk",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="E-commerce Platform"),
     *             @OA\Property(property="description", type="string", example="Website e-commerce dengan fitur lengkap"),
     *             @OA\Property(property="price", type="number", format="float", example=25000000),
     *             @OA\Property(property="image_path", type="string", example="products/abc123.jpg"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/product",
     *     summary="Tambah produk baru",
     *     description="Membuat produk baru dengan upload gambar. Endpoint ini memerlukan autentikasi.",
     *     operationId="storeProduct",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data produk yang akan dibuat (multipart/form-data)",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"client_id", "name", "price", "description", "image_path"},
     *                 @OA\Property(
     *                     property="client_id",
     *                     type="integer",
     *                     description="ID client yang memiliki produk",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nama produk",
     *                     example="E-commerce Platform"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     format="float",
     *                     description="Harga produk dalam Rupiah",
     *                     example=25000000
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Deskripsi lengkap produk",
     *                     example="Website e-commerce dengan fitur lengkap termasuk payment gateway"
     *                 ),
     *                 @OA\Property(
     *                     property="image_path",
     *                     type="string",
     *                     format="binary",
     *                     description="File gambar produk (jpeg, png, jpg, gif, svg, max 5MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="E-commerce Platform"),
     *                 @OA\Property(property="description", type="string", example="Website e-commerce dengan fitur lengkap"),
     *                 @OA\Property(property="price", type="number", example=25000000),
     *                 @OA\Property(property="image_path", type="string", example="products/abc123.jpg"),
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
     *                     property="client_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The client id field is required.")
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
            'client_id' => 'nullable|integer|exists:our_clients,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400', // 100MB in KB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
        ]);

        // Upload main image using StorageService
        $imagePath = $this->storageService->upload($request->file('image_path'), 'products');

        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagesPaths[] = $this->storageService->upload($file, 'products');
            }
        }

        $product = Product::create([
            'client_id' => $request->client_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => $imagePath,
            'images' => $imagesPaths,
        ]);

        // Clear landing page cache
        cache()->forget('landing_page_data');

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/product/{id}",
     *     summary="Update produk yang sudah ada",
     *     description="Mengupdate data produk berdasarkan ID. Semua field bersifat opsional. Endpoint ini memerlukan autentikasi.",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID produk yang akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Data produk yang akan diupdate (multipart/form-data). Tambahkan _method=PUT untuk Laravel.",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     description="Method spoofing untuk Laravel (PUT)",
     *                     example="PUT"
     *                 ),
     *                 @OA\Property(
     *                     property="client_id",
     *                     type="integer",
     *                     description="ID client (opsional)",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nama produk (opsional)",
     *                     example="E-commerce Platform Updated"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     format="float",
     *                     description="Harga produk (opsional)",
     *                     example=30000000
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Deskripsi produk (opsional)",
     *                     example="Deskripsi yang sudah diupdate"
     *                 ),
     *                 @OA\Property(
     *                     property="image_path",
     *                     type="string",
     *                     format="binary",
     *                     description="File gambar baru (opsional, jpeg, png, jpg, gif, svg, max 5MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="E-commerce Platform Updated"),
     *                 @OA\Property(property="description", type="string", example="Deskripsi yang sudah diupdate"),
     *                 @OA\Property(property="price", type="number", example=30000000),
     *                 @OA\Property(property="image_path", type="string", example="products/new123.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
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
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'client_id' => 'nullable|integer|exists:our_clients,id',
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'image_path' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400', // 100MB in KB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
            'deleted_images' => 'nullable|array', // Array of public IDs to delete
        ]);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            if ($product->image_path) {
                // Delete old image from storage
                $this->storageService->delete($product->image_path);
            }
            $product->image_path = $this->storageService->upload($request->file('image_path'), 'products');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $existingImages = $product->images ?? [];
            $newImages = [];

            foreach ($request->file('images') as $file) {
                $newImages[] = $this->storageService->upload($file, 'products');
            }

            // Merge with existing images
            $product->images = array_merge($existingImages, $newImages);
        }

        // Handle deleting specific images
        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            $existingImages = $product->images ?? [];

            foreach ($request->deleted_images as $pathToDelete) {
                // Remove from array
                $existingImages = array_filter($existingImages, function($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                });

                // Delete from storage
                $this->storageService->delete($pathToDelete);
            }

            $product->images = array_values($existingImages); // Re-index array
        }

        $updateData = $request->only(['client_id', 'name', 'price', 'description']);
        $product->fill($updateData);
        $product->save();

        // Clear landing page cache
        cache()->forget('landing_page_data');

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/product/{id}",
     *     summary="Hapus produk",
     *     description="Menghapus produk berdasarkan ID. File gambar yang terkait juga akan dihapus. Endpoint ini memerlukan autentikasi.",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID produk yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
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
        $product = Product::find($id);
        if ($product) {
            // Delete main image from storage if exists
            if ($product->image_path) {
                $this->storageService->delete($product->image_path);
            }

            // Delete additional images from storage if exist
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $path) {
                    $this->storageService->delete($path);
                }
            }

            $product->delete();

            // Clear landing page cache
            cache()->forget('landing_page_data');

            return response()->json(['message' => 'Product deleted successfully']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
