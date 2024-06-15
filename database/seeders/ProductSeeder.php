<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();

        for($i = 0; $i < 500; $i++) {
            Product::create([
                'name' => fake()->lastName(),
                'sku' => fake()->numerify('P####S#####K##'),
                'brand' => fake()->company(),
                'supplier_id' => $suppliers->random()->id,
                'purchase_price' => fake()->randomFloat(2, 1, 1000),
                'sale_price' => fake()->randomFloat(2, 1, 1000),
                'total_amount' => fake()->numberBetween(1, 10000),
                'minimum_amount' => fake()->numberBetween(1, 100),
                'storage_location' => fake()->streetName(),
                'expiry_date' => fake()->dateTimeBetween('-6 months', '+1 year')->format('Y-m-d'),
                'description' => fake()->text(500),
                'additional_info' => fake()->text(200),
            ]);
        }
    }
}
