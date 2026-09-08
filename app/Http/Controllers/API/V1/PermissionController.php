<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    // list all permissions
    public function index()
    {
        return response()->json([
            'data' => Permission::all()
        ]);
    }

    // assign permissions to a role
    public function assignToRole(Request $request, string $id)
    {
        $validated = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findById($id, 'web');
        $role->syncPermissions($validated['permissions']);

        return response()->json([
            'message' => 'Permissions assigned successfully.',
            'role'    => $role->load('permissions'),
        ]);
    }

    // get permissions of a role
    public function rolePermissions(string $id)
    {
        $role = Role::findById($id, 'web');

        return response()->json([
            'data' => $role->permissions
        ]);
    }
}
