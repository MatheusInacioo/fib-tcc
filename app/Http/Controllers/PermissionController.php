<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions:id,name')->select('id', 'name')->get();

        return Inertia::render('Settings/Permissions/Index', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $permissions = $request->input('permissions');
            $groupedPermissions = [];

            foreach ($permissions as $permission) {
                $groupedPermissions[$permission['role_id']][] = $permission['name'];
            }

            foreach ($groupedPermissions as $roleId => $permissionNames) {
                $role = Role::findOrFail($roleId);
                $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();

                $existingPermissions = $role->permissions('id');

                $permissionsToRemove = array_diff($existingPermissions, $permissionIds);

                if (!empty($permissionsToRemove)) {
                    $role->permissions()->detach($permissionsToRemove);
                }

                $role->permissions()->sync($permissionIds);
            }

            return redirect()->route('permissions.index')->with('success', 'Permissões atualizadas com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('permissions.index')->with('error', 'Ocorreu um erro ao salvar as permissões: ' . $ex->getMessage());
        }
    }

    public function hasPermission($roleId, $permissionName)
    {
        $role = Role::findOrFail($roleId);

        return $role->permissions()->where('name', $permissionName)->exists();
    }

    public function getPermissions()
    {
        $roles = Role::with('permissions:id,name')->select('id', 'name')->get();
        $permissions = [];

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = [
                    'role_id' => $role->id,
                    'name' => $permission->name,
                ];
            }
        }

        return response()->json($permissions);
    }
}
