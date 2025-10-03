<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {   
        $admins = Admin::all();
        return response()->json($admins);
    }

    public function show($id)
    {
        $Admin = Admin::find($id);
        if ($Admin) {
            return response()->json($Admin);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $Admin = Admin::create($request->all());
        return response()->json([
            "message" => "Admin created successfully",
            "data" => $Admin
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'sometimes|required|string',
            'password' => 'sometimes|required|string',
        ]);

        $Admin = Admin::find($id);
        if ($Admin) {
            $Admin->update($request->all());
            return response()->json([
                "message" => "Admin updated successfully",
                "data" => $Admin
            ]);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    public function destroy($id)
    {
        $Admin = Admin::find($id);
        if ($Admin) {
            $Admin->delete();
            return response()->json(['message' => 'Admin deleted successfully']);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }
}
