<?php

namespace Database\Seeders;

use App\Enums\ActivationStatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            'email' => 'user1@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt(123),
            'company_id' => 1,
            'shop_id' => rand(1, 2),
            'active' => ActivationStatusEnum::ACTIVE,
        ]);

        for ($i = 2; $i < 9; $i++) {
            User::create([
                'name' => fake()->name(),
                'role_id' => rand(1, 3),
                'email' => "user{$i}@email.com",
                'email_verified_at' => now(),
                'password' => bcrypt(123),
                'company_id' => 1,
                'shop_id' => rand(1, 2),
                'active' => ActivationStatusEnum::ACTIVE,
            ]);
        }
    }
}
