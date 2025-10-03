<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {   
        $products = Product::all();
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
        $request->validate([
            'client_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        $product = Product::find($id);
        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_path = $imagePath;
        }

        // Update other fields
        $product->fill($request->only(['client_id', 'name', 'price', 'description']));
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
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
