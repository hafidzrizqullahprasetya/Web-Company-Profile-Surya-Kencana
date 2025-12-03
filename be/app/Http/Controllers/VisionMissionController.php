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
        $request->validate([
            "vision" => "sometimes|required|string",
            "mission" => "sometimes|required|string",
        ]);

        $visionMission = VisionMission::first();
        if ($visionMission) {
            $visionMission->update($request->all());

            return response()->json([
                "message" => "Vision and Mission updated successfully",
                "data" => $visionMission,
            ]);
        } else {
            return response()->json(
                ["message" => "Vision and Mission not found"],
                404,
            );
        }
    }
}
