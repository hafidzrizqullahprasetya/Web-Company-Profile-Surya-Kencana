<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {   
        $testimonial = Testimonial::all();
        return response()->json($testimonial);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'feedback' => 'required|string',
            'date' => 'required|date',
        ]);

        $testimonial = Testimonial::create($request->all());
        return response()->json([
            "message" => "Testimonial created successfully",
            "data" => $testimonial
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'feedback' => 'required|string',
            'date' => 'required|date',
        ]);

        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->update($request->all());
            return response()->json([
                "message" => "Testimonial updated successfully",
                "data" => $testimonial
            ]);
        } else {
            return response()->json(['message' => 'Testimonial not found'], 404);
        }
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->delete();
            return response()->json(['message' => 'Testimonial deleted successfully']);
        } else {
            return response()->json(['message' => 'Testimonial not found'], 404);
        }
    }
}
