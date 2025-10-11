<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {   
        $contact = Contact::all();
        return response()->json($contact);
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'map_url' => 'sometimes|required|url',
        ]);

        $contact = Contact::first();
        if ($contact) {
            $contact->update($request->all());
            return response()->json([
                "message" => "Contact updated successfully",
                "data" => $contact
            ]);
        } else {
            return response()->json(['message' => 'Contact not found'], 404);
        }
    }
}
