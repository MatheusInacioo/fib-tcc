<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => fake()->lastName(),
            'company_id' => 1,
            'shop_id' => rand(1, 2),
            'corporate_name' => fake()->company(),
            'active' => true,
        ]);
    }
}
