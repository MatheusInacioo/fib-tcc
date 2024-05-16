<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i <= 500; $i++) {
            Product::create([
                'name' => fake()->name(),
                'sku' => fake()->numerify('P####S#####K##'),
                'brand' => fake()->company(),
                'supplier_id' => fake()->int(),
                'purchase_price' => fake()->numerify('###.##'),
                'sale_price' => fake()->numerify('###.##'),
                'total_amount' => fake()->numerify('####'),
                'minimum_amount' => fake()->numerify('##'),
                'storage_location' => fake()->name(),
                'expiry_date' => fake()->date(),
                'description' => fake()->text(500),
                'additional_info' => fake()->text(200),
            ]);
        }
    }
}
