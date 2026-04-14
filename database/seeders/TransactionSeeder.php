<?php

namespace Database\Seeders;

use App\Enums\TransactionTypeEnum;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $users = User::all();
        $paymentMethods = [
            'Dinheiro',
            'Cartão de Crédito',
            'Boleto',
            'Transferência',
        ];

        for ($i = 0; $i < 100; $i++) {
            $transactionType = fake()->randomElement(TransactionTypeEnum::cases());
            $quantity = fake()->numberBetween(1, 100);
            $date = fake()->dateTimeBetween('-30 days', 'now');

            if ($transactionType === TransactionTypeEnum::PURCHASE) {
                $supplier = $suppliers->random();
                $products = Product::where('supplier_id', $supplier->id)->get();
                $product = $products->random();

                Transaction::create([
                    'type' => TransactionTypeEnum::PURCHASE,
                    'company_id' => 1,
                    'shop_id' => rand(1, 2),
                    'customer_id' => null,
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->purchase_price,
                    'total_amount' => $product->purchase_price * $quantity,
                    'payment_method' => fake()->randomElement($paymentMethods),
                    'notes' => fake()->text(200),
                    'user_id' => $users->random()->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            } else {
                $products = Product::all();
                $product = $products->random();

                Transaction::create([
                    'type' => TransactionTypeEnum::SALE,
                    'company_id' => 1,
                    'shop_id' => rand(1, 2),
                    'customer_id' => $customers->random()->id,
                    'supplier_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->sale_price,
                    'total_amount' => $product->sale_price * $quantity,
                    'payment_method' => fake()->randomElement($paymentMethods),
                    'notes' => fake()->text(200),
                    'user_id' => $users->random()->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
