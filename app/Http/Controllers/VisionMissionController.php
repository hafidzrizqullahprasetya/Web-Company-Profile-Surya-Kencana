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

    public function show($id)
    {
        $visionMission = VisionMission::find($id);
        if ($visionMission) {
            return response()->json($visionMission);
        } else {
            return response()->json(['message' => 'Vision and Mission not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
        'vision' => 'required|string',
        'mission' => 'required|string',
        ]);

        $visionMission = VisionMission::create($request->all());
        return response()->json([
            "message" => "Vision and Mission created successfully",
            "data" => $visionMission
        ], 201);
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

    public function destroy($id)
    {
        $visionMission = VisionMission::find($id);
        if ($visionMission) {
            $visionMission->delete();
            return response()->json(['message' => 'Vision and Mission deleted successfully']);
        } else {
            return response()->json(['message' => 'Vision and Mission not found'], 404);
        }
    }

}
