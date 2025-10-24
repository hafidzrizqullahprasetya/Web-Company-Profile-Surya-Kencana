<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {   
        $products = Product::with('client')->get();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        $imagePath = $request->file('image_path')->store('products', 'public');

        $product = Product::create([
        'client_id' => $request->client_id,
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'image_path' => $imagePath,
    ]);

    return response()->json([
        'message' => 'Product created successfully',
        'data' => $product
    ], 201);
    }

    public function update(Request $request, $id)
    {   
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'client_id' => 'sometimes|integer',
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'image_path' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        if ($request->hasFile('image_path')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $imagePath = $request->file('image_path')->store('products', 'public');
            $product->image_path = $imagePath;
        }

        $updateData = $request->only(['client_id', 'name', 'price', 'description']);
        $product->fill($updateData);
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh()
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }    
}
