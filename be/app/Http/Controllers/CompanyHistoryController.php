<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyHistory;
use App\Services\StorageService;

class CompanyHistoryController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function index()
    {
        $histories = CompanyHistory::orderBy('tahun', 'asc')->get();
        return response()->json($histories);
    }

    public function show($id)
    {
        $history = CompanyHistory::find($id);
        if ($history) {
            return response()->json($history);
        } else {
            return response()->json(['message' => 'Company history not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400', // 100MB in KB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->storageService->upload($request->file('image'), 'company-histories');
        }

        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagesPaths[] = $this->storageService->upload($file, 'company-histories');
            }
        }

        $history = CompanyHistory::create([
            'tahun' => $request->tahun,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
            'images' => $imagesPaths,
        ]);

        return response()->json([
            'message' => 'Company history created successfully',
            'data' => $history
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $history = CompanyHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'Company history not found'], 404);
        }

        $request->validate([
            'tahun' => 'sometimes|integer|min:1900|max:' . (date('Y') + 10),
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400', // 100MB in KB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
            'deleted_images' => 'nullable|array', // Array of paths to delete
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($history->image_path) {
                $this->storageService->delete($history->image_path);
            }

            $history->image_path = $this->storageService->upload($request->file('image'), 'company-histories');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $existingImages = $history->images ?? [];
            $newImages = [];

            foreach ($request->file('images') as $file) {
                $newImages[] = $this->storageService->upload($file, 'company-histories');
            }

            // Merge with existing images
            $history->images = array_merge($existingImages, $newImages);
        }

        // Handle deleting specific images
        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            $existingImages = $history->images ?? [];

            foreach ($request->deleted_images as $pathToDelete) {
                // Remove from array
                $existingImages = array_filter($existingImages, function($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                });

                // Delete file from storage
                $this->storageService->delete($pathToDelete);
            }

            $history->images = array_values($existingImages); // Re-index array
        }

        $updateData = $request->only(['tahun', 'judul', 'deskripsi']);
        $history->fill($updateData);
        $history->save();

        return response()->json([
            'message' => 'Company history updated successfully',
            'data' => $history
        ]);
    }

    public function destroy($id)
    {
        $history = CompanyHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'Company history not found'], 404);
        }

        // Delete image if exists
        if ($history->image_path) {
            $this->storageService->delete($history->image_path);
        }

        // Delete additional images if exist
        if ($history->images && is_array($history->images)) {
            foreach ($history->images as $path) {
                $this->storageService->delete($path);
            }
        }

        $history->delete();

        return response()->json([
            'message' => 'Company history deleted successfully'
        ]);
    }
}
