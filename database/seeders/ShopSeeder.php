<?php

namespace Database\Seeders;

use App\Enums\ActivationStatusEnum;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 2; $i++) {
            Shop::create([
                'name' => fake()->word(),
                'company_id' => 1,
                'location' => fake()->address(),
                'active' => ActivationStatusEnum::ACTIVE,
            ]);
        }
    }
}
