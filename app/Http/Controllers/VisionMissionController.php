<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {   
        $visionMissions = VisionMission::all();
        return response()->json($visionMissions);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vision' => 'sometimes|required|string',
            'mission' => 'sometimes|required|string',
        ]);

        $visionMission = VisionMission::find($id);
        if ($visionMission) {
            $visionMission->update($request->all());
            return response()->json([
                "message" => "Vision and Mission updated successfully",
                "data" => $visionMission
            ]);
        } else {
            return response()->json(['message' => 'Vision and Mission not found'], 404);
        }
    }
}
