<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminPreference;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminPreferenceController extends Controller
{
    /**
     * Get admin preferences
     */
    public function getPreferences($adminId): JsonResponse
    {
        try {
            $admin = Admin::find($adminId);

            if (!$admin) {
                return response()->json(
                    ['message' => 'Admin not found'],
                    404
                );
            }

            $preference = AdminPreference::where('admin_id', $adminId)->firstOrCreate(
                ['admin_id' => $adminId],
                [
                    'sidebar_state' => 'open',
                    'menu_order' => null,
                ]
            );

            return response()->json($preference, 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Error fetching preferences', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Update admin preferences
     */
    public function updatePreferences($adminId, Request $request): JsonResponse
    {
        try {
            $admin = Admin::find($adminId);

            if (!$admin) {
                return response()->json(
                    ['message' => 'Admin not found'],
                    404
                );
            }

            $validated = $request->validate([
                'sidebar_state' => 'sometimes|in:open,closed',
                'menu_order' => 'sometimes|array',
            ]);

            $preference = AdminPreference::where('admin_id', $adminId)->firstOrCreate(
                ['admin_id' => $adminId],
                [
                    'sidebar_state' => 'open',
                    'menu_order' => null,
                ]
            );

            $preference->update($validated);

            return response()->json($preference, 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Error updating preferences', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Update sidebar state
     */
    public function updateSidebarState($adminId, Request $request): JsonResponse
    {
        try {
            $admin = Admin::find($adminId);

            if (!$admin) {
                return response()->json(
                    ['message' => 'Admin not found'],
                    404
                );
            }

            $validated = $request->validate([
                'sidebar_state' => 'required|in:open,closed',
            ]);

            $preference = AdminPreference::where('admin_id', $adminId)->firstOrCreate(
                ['admin_id' => $adminId],
                [
                    'sidebar_state' => 'open',
                    'menu_order' => null,
                ]
            );

            $preference->update(['sidebar_state' => $validated['sidebar_state']]);

            return response()->json($preference, 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Error updating sidebar state', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Update menu order
     */
    public function updateMenuOrder($adminId, Request $request): JsonResponse
    {
        try {
            $admin = Admin::find($adminId);

            if (!$admin) {
                return response()->json(
                    ['message' => 'Admin not found'],
                    404
                );
            }

            $validated = $request->validate([
                'menu_order' => 'required|array',
            ]);

            $preference = AdminPreference::where('admin_id', $adminId)->firstOrCreate(
                ['admin_id' => $adminId],
                [
                    'sidebar_state' => 'open',
                    'menu_order' => null,
                ]
            );

            $preference->update(['menu_order' => $validated['menu_order']]);

            return response()->json($preference, 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Error updating menu order', 'error' => $e->getMessage()],
                500
            );
        }
    }
}
