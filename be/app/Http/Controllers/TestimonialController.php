<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(
            Testimonial::performanceSelect()
                ->orderBy("order", "asc")
                ->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            "client_name" => "required|string",
            "institution" => "required|string",
            "feedback" => "required|string",
            "date" => "required|date",
            "order" => "nullable|integer|min:0",
        ]);

        // Get max order
        $maxOrder = Testimonial::max('order') ?? 0;
        
        // Use provided order or auto-increment
        $order = $request->order ?? ($maxOrder + 1);

        // If inserting at a specific position, shift existing items
        if ($request->has('order') && $request->order <= $maxOrder) {
            Testimonial::where('order', '>=', $request->order)
                ->increment('order');
        }

        $testimonial = Testimonial::create([
            "client_name" => $request->client_name,
            "institution" => $request->institution,
            "feedback" => $request->feedback,
            "date" => $request->date,
            "order" => $order,
        ]);

        return response()->json(
            [
                "message" => "Testimonial created successfully",
                "data" => $testimonial,
            ],
            201,
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "client_name" => "required|string",
            "institution" => "required|string",
            "feedback" => "required|string",
            "date" => "required|date",
        ]);

        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->update($request->all());

            return response()->json([
                "message" => "Testimonial updated successfully",
                "data" => $testimonial,
            ]);
        } else {
            return response()->json(
                ["message" => "Testimonial not found"],
                404,
            );
        }
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->delete();

            return response()->json([
                "message" => "Testimonial deleted successfully",
            ]);
        } else {
            return response()->json(
                ["message" => "Testimonial not found"],
                404,
            );
        }
    }

    public function reorder(Request $request)
    {
        try {
            $testimonials = $request->input('testimonials');

            foreach ($testimonials as $testimonial) {
                Testimonial::where('id', $testimonial['id'])
                    ->update(['order' => $testimonial['order']]);
            }

            return response()->json([
                "message" => "Testimonial order updated successfully",
            ]);
        } catch (\Exception $e) {
            \Log::error("Error reordering testimonials: " . $e->getMessage());
            return response()->json(
                [
                    "message" => "Error reordering testimonials",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
