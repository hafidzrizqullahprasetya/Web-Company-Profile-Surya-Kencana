<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function adminlogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'admin' => [
                    'id' => $admin->id,
                    'username' => $admin->username
                ]
            ]);
        } else{
            return response()->json(['message' => 'Invalid username or password'], 401);
        }
    }

    public function superadminlogin(Request $request){
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);
        
        $superadmin = SuperAdmin::where('username', $request->username)->first();

        if ($superadmin && Hash::check($request->password, $superadmin->password)) {
            $token = $superadmin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'admin' => [
                    'id' => $superadmin->id,
                    'username' => $superadmin->username
                ]
            ]);
        } else{
            return response()->json(['message' => 'Invalid username or password'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        /** @var \Laravel\Sanctum\PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();
        
        if ($token) {
            $token->delete();
            return response()->json(['message' => 'Logout successful']);
        }
        
        return response()->json(['message' => 'No active token found'], 401);
    }
}
