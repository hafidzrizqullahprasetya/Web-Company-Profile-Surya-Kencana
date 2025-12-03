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
        $histories = CompanyHistory::performanceSelect()
            ->orderBy('order', 'asc')
            ->get();

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
            'order' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
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

        $maxOrder = CompanyHistory::max('order') ?? 0;
        $order = $request->order ?? ($maxOrder + 1);

        $history = CompanyHistory::create([
            'tahun' => $request->tahun,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
            'images' => $imagesPaths,
            'order' => $order,
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
            'order' => 'nullable|integer|min:1',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:102400',
            'deleted_images' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($history->image_path) {
                $this->storageService->delete($history->image_path);
            }

            $history->image_path = $this->storageService->upload($request->file('image'), 'company-histories');
        }

        if ($request->hasFile('images')) {
            $existingImages = $history->images ?? [];
            $newImages = [];

            foreach ($request->file('images') as $file) {
                $newImages[] = $this->storageService->upload($file, 'company-histories');
            }

            $history->images = array_merge($existingImages, $newImages);
        }

        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            $existingImages = $history->images ?? [];

            foreach ($request->deleted_images as $pathToDelete) {
                $existingImages = array_filter($existingImages, function($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                });

                $this->storageService->delete($pathToDelete);
            }

            $history->images = array_values($existingImages);
        }

        $updateData = $request->only(['tahun', 'judul', 'deskripsi', 'order']);
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

        if ($history->image_path) {
            $this->storageService->delete($history->image_path);
        }

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

    public function reorder(Request $request)
    {
        try {
            $histories = $request->input('histories');

            foreach ($histories as $history) {
                CompanyHistory::where('id', $history['id'])
                    ->update(['order' => $history['order']]);
            }

            return response()->json([
                "message" => "Company history order updated successfully",
            ]);
        } catch (\Exception $e) {
            \Log::error("Error reordering company histories: " . $e->getMessage());
            return response()->json(
                [
                    "message" => "Error reordering company histories",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
