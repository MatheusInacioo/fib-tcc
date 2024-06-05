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
            'export-transactions',
            'delete-transactions',
            'list-customers',
            'export-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            'list-suppliers',
            'export-suppliers',
            'create-suppliers',
            'edit-suppliers',
            'delete-suppliers',
            'list-crm',
            'export-crm',
            'create-crm',
            'edit-crm',
            'delete-crm',
            'list-products',
            'export-products',
            'create-products',
            'edit-products',
            'delete-products',
        ];

        foreach($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
    }
}
