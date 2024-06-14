<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 100; $i++) {
            Supplier::create([
                'name' => fake()->company(),
                'cnpj' => fake()->numerify('##.###.###/0001-##'),
                'email' => fake()->unique()->safeEmail(),
                'address' => fake()->address(),
                'zip_code' => fake()->numerify('#####-###'),
                'phone' => fake()->numerify('(##)####-####'),
                'responsible' => fake()->name(),
                'responsible_phone' => fake()->numerify('(##)#####-####'),
                'segment' => fake()->randomElement(['Atacado', 'Varejo', 'Transportes', 'Distribuidora', 'Alimentação']),
            ]);
        }
    }
}
