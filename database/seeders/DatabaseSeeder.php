<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            CrmSeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
