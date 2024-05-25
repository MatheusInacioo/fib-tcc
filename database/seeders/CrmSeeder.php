<?php

namespace Database\Seeders;

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
                'cnpj' => fake()->numerify('##.###.###/0001-##'),
                'email' => fake()->unique()->safeEmail(),
                'address' => fake()->address(),
                'phone' => fake()->numerify('(##)####-####'),
                'responsible' => fake()->name(),
                'responsible_phone' => fake()->numerify('(##)#####-####'),
                'segment' => fake()->randomElement(['Atacado', 'Varejo', 'Transportes', 'Distribuidora', 'Alimentação']),
                'type' => fake()->randomElement(['Fornecedor', 'Cliente']),
                'status' => fake()->randomElement([
                    'Contato',
                    'Negociação',
                    'Assinatura Pendente',
                    'Standby',
                    'Sem Interesse',
                ]),
            ]);
        }
    }
}
