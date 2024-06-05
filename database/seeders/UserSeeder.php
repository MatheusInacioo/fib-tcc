<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'role_id' => 1,
            'email' => 'email@estoque.com',
            'password' => bcrypt('senha'),
        ]);

        User::factory(9)->create();
    }
}
