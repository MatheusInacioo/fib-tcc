<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Administrador',
            'Suporte',
            'Financeiro',
        ];

        foreach($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
