<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        try {
            return response()->json(VisionMission::performanceSelect()->get());
        } catch (\Exception $e) {
            \Log::error("Error fetching vision mission: " . $e->getMessage());
            return response()->json(
                [
                    "vision" => null,
                    "mission" => null,
                ],
                200,
            );
        }
    }

    public function update(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!$request->user()) {
                return response()->json(
                    ["message" => "Unauthenticated"],
                    401
                );
            }

            $validated = $request->validate([
                "vision" => "sometimes|required|string",
                "mission" => "sometimes|required|string",
            ]);

            $visionMission = VisionMission::first();
            
            if (!$visionMission) {
                return response()->json(
                    ["message" => "Vision and Mission not found"],
                    404
                );
            }

            $visionMission->update($validated);

            return response()->json([
                "message" => "Vision and Mission updated successfully",
                "data" => $visionMission,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error updating vision mission: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                "message" => "Failed to update Vision and Mission",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
