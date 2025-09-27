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
}
