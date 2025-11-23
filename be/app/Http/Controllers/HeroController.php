<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Services\StorageService;

class HeroController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function index()
    {
        $heroes = Hero::all();
        return response()->json($heroes);
    }

    public function show($id)
    {
        $hero = Hero::find($id);
        if ($hero) {
            return response()->json($hero);
        } else {
            return response()->json(['message' => 'Hero not found'], 404);
        }
    }

    public function update(Request $request)
    {
        // Get the first hero record (singleton pattern)
        $hero = Hero::first();

        if (!$hero) {
            // Create if doesn't exist
            $hero = new Hero();
        }

        // All fields are optional
        $request->validate([
            'location' => 'nullable|string|max:255',
            'title' => 'nullable|string',
            'machines' => 'nullable|integer|min:0',
            'clients' => 'nullable|integer|min:0',
            'customers' => 'nullable|integer|min:0',
            'experience_years' => 'nullable|integer|min:0',
            'trust_years' => 'nullable|integer|min:0',
            'backgrounds' => 'nullable|array',
            'backgrounds.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:102400', // max 100MB per image
            'deleted_backgrounds' => 'nullable|array', // Array of paths to delete
        ]);

        // Handle multiple background images upload
        if ($request->hasFile('backgrounds')) {
            $existingBackgrounds = $hero->backgrounds ?? [];
            $newBackgrounds = [];

            foreach ($request->file('backgrounds') as $file) {
                $newBackgrounds[] = $this->storageService->upload($file, 'heroes');
            }

            // Merge with existing backgrounds
            $hero->backgrounds = array_merge($existingBackgrounds, $newBackgrounds);
        }

        // Handle deleting specific backgrounds
        if ($request->has('deleted_backgrounds') && is_array($request->deleted_backgrounds)) {
            $existingBackgrounds = $hero->backgrounds ?? [];

            foreach ($request->deleted_backgrounds as $pathToDelete) {
                // Remove from array
                $existingBackgrounds = array_filter($existingBackgrounds, function($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                });

                // Delete file from storage
                $this->storageService->delete($pathToDelete);
            }

            $hero->backgrounds = array_values($existingBackgrounds); // Re-index array
        }

        // Update other fields only if provided
        $updateData = $request->only([
            'location',
            'title',
            'machines',
            'clients',
            'customers',
            'experience_years',
            'trust_years'
        ]);

        // Remove null values to avoid overwriting existing data with null
        $updateData = array_filter($updateData, function($value) {
            return $value !== null;
        });

        $hero->fill($updateData);
        $hero->save();

        // Clear landing page cache
        cache()->forget('landing_page_data');

        return response()->json([
            'message' => 'Hero updated successfully',
            'data' => $hero
        ]);
    }
}
