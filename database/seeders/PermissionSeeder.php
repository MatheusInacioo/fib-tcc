<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'list-transactions',
            'create-transactions',
            'delete-transactions',
            'list-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            'list-suppliers',
            'create-suppliers',
            'edit-suppliers',
            'delete-suppliers',
            'list-crm',
            'create-crm',
            'edit-crm',
            'delete-crm',
            'list-products',
            'create-products',
            'edit-products',
            'delete-products',
        ];

        foreach($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
    }
}
