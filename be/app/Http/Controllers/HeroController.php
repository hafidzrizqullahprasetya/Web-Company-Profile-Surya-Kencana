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
        try {
            return response()->json(Hero::performanceSelect()->get());
        } catch (\Exception $e) {
            \Log::error("Error fetching hero: " . $e->getMessage());
            return response()->json(
                [
                    "location" => null,
                    "title" => null,
                    "machines" => 0,
                    "clients" => 0,
                    "customers" => 0,
                    "experience_years" => 0,
                    "trust_years" => 0,
                    "backgrounds" => [],
                ],
                200,
            );
        }
    }

    public function show($id)
    {
        $hero = Hero::find($id);
        if ($hero) {
            return response()->json($hero);
        } else {
            return response()->json(["message" => "Hero not found"], 404);
        }
    }

    public function update(Request $request)
    {
        $hero = Hero::first();

        if (!$hero) {
            $hero = new Hero();
        }

        $request->validate([
            "location" => "nullable|string|max:255",
            "title" => "nullable|string",
            "machines" => "nullable|integer|min:0",
            "clients" => "nullable|integer|min:0",
            "customers" => "nullable|integer|min:0",
            "experience_years" => "nullable|integer|min:0",
            "trust_years" => "nullable|integer|min:0",
            "backgrounds" => "nullable|array",
            "backgrounds.*" => "image|mimes:jpeg,png,jpg,gif,webp|max:102400",
            "deleted_backgrounds" => "nullable|array",
        ]);

        if ($request->hasFile("backgrounds")) {
            $existingBackgrounds = $hero->backgrounds ?? [];
            $newBackgrounds = [];

            foreach ($request->file("backgrounds") as $file) {
                $newBackgrounds[] = $this->storageService->upload(
                    $file,
                    "heroes",
                );
            }

            $hero->backgrounds = array_merge(
                $existingBackgrounds,
                $newBackgrounds,
            );
        }

        if (
            $request->has("deleted_backgrounds") &&
            is_array($request->deleted_backgrounds)
        ) {
            $existingBackgrounds = $hero->backgrounds ?? [];

            foreach ($request->deleted_backgrounds as $pathToDelete) {
                $existingBackgrounds = array_filter(
                    $existingBackgrounds,
                    function ($path) use ($pathToDelete) {
                        return $path !== $pathToDelete;
                    },
                );

                $this->storageService->delete($pathToDelete);
            }

            $hero->backgrounds = array_values($existingBackgrounds);
        }

        $updateData = $request->only([
            "location",
            "title",
            "machines",
            "clients",
            "customers",
            "experience_years",
            "trust_years",
        ]);

        $updateData = array_filter($updateData, function ($value) {
            return $value !== null;
        });

        $hero->fill($updateData);
        $hero->save();

        return response()->json([
            "message" => "Hero updated successfully",
            "data" => $hero,
        ]);
    }
}
