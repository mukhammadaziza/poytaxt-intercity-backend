<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        return RoleResource::collection($roles);
    }
    
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function edit()
    {

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required']
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        return response()->json([
            'message' => 'Role created successfully.',
            'role' => $role,
        ], 201);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
                    'name' => ['required']
                ]);

        $role->update($validated);

        return response()->json([
            'message' => 'Role updated successfully.',
            'role' => $role,
        ], 200);
    }

    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
        return response()->json([
            'message' => 'This role is assigned to users and cannot be deleted.'
        ], 422);
        }

        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully.'
        ], 200);
    }
}
