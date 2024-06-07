<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $permissions = $request->input('markedPermissions');
            $groupedPermissions = [];

            if(! $permissions) {
                $roleIds = Role::pluck('id')->toArray();

                foreach($roleIds as $roleId) {
                    DB::table('role_permission')->where('role_id', $roleId)->delete();
                }

                return redirect()->route('settings.index')->with('success', 'Permissões atualizadas com sucesso.');
            }

            foreach ($permissions as $permission) {
                $groupedPermissions[$permission['role_id']][] = $permission['name'];
            }

            foreach ($groupedPermissions as $roleId => $permissionNames) {
                $role = Role::findOrFail($roleId);

                $currentPermissions = $role->permissions->pluck('name')->toArray();

                $permissionsToAdd = array_diff($permissionNames, $currentPermissions);
                $permissionsToRemove = array_diff($currentPermissions, $permissionNames);

                $permissionIdsToAdd = Permission::whereIn('name', $permissionsToAdd)->pluck('id')->toArray();
                $role->permissions()->attach($permissionIdsToAdd);

                $permissionIdsToRemove = Permission::whereIn('name', $permissionsToRemove)->pluck('id')->toArray();
                $role->permissions()->detach($permissionIdsToRemove);
            }

            return redirect()->route('settings.index')->with('success', 'Permissões atualizadas com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('settings.index')->with('error', 'Ocorreu um erro ao salvar as permissões: ' . $ex->getMessage());
        }
    }

    public function hasPermission($roleId, $permissionName)
    {
        $role = Role::findOrFail($roleId);

        return $role->permissions()->where('name', $permissionName)->exists();
    }

    public function fetchPermissions()
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
