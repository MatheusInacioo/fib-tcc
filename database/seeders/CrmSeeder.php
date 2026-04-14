<?php

namespace Database\Seeders;

use App\Enums\CrmLeadStatusEnum;
use App\Enums\CrmPartyTypeEnum;
use App\Models\Crm;
use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            Crm::create([
                'name' => fake()->company(),
                'company_id' => 1,
                'shop_id' => rand(1, 2),
                'cnpj' => fake()->numerify('##.###.###/0001-##'),
                'email' => fake()->unique()->safeEmail(),
                'address' => fake()->address(),
                'zip_code' => fake()->numerify('#####-###'),
                'phone' => fake()->numerify('(##)####-####'),
                'responsible' => fake()->name(),
                'responsible_phone' => fake()->numerify('(##)#####-####'),
                'segment' => fake()->randomElement(['Atacado', 'Varejo', 'Transportes', 'Distribuidora', 'Alimentação']),
                'type' => fake()->randomElement(CrmPartyTypeEnum::cases()),
                'status' => fake()->randomElement(CrmLeadStatusEnum::cases()),
            ]);
        }
    }
}
