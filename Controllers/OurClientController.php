<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OurClient;
use Illuminate\Support\Facades\Storage;

class OurClientController extends Controller
{
    public function index()
    {   
        $clients = OurClient::all();
        return response()->json($clients);
    }

    public function show($id)
    {
        $client = OurClient::find($id);
        if ($client) {
            return response()->json($client);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'logo_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        $logoPath = $request->file('logo_path')->store('ourClients', 'public');

        $client = OurClient::create([
            'client_name' => $request->client_name,
            'institution' => $request->institution,
            'logo_path' => $logoPath,
        ]);

    return response()->json([
        'message' => 'Client created successfully',
        'data' => $client
    ], 201);
    }

    public function update(Request $request, $id)
    {   
        $client = OurClient::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $request->validate([
            'client_name' => 'required|string',
            'institution' => 'required|string',
            'logo_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        if ($request->hasFile('logo_path')) {
            if ($client->logo_path && Storage::disk('public')->exists($client->logo_path)) {
                Storage::disk('public')->delete($client->logo_path);
            }

            $logoPath = $request->file('logo_path')->store('ourClients', 'public');
            $client->logo_path = $logoPath;
        }

        $updateData = $request->only(['client_name', 'institution']);
        $client->fill($updateData);
        $client->save();

        return response()->json([
            'message' => 'Client updated successfully',
            'data' => $client->fresh()
        ]);
    }

    public function destroy($id)
    {
        $client = OurClient::find($id);
        if ($client) {
            if ($client->logo_path && Storage::disk('public')->exists($client->logo_path)) {
                Storage::disk('public')->delete($client->logo_path);
            }

            $client->delete();
            return response()->json(['message' => 'Client deleted successfully']);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }    
}
