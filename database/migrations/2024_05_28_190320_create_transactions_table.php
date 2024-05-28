<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->boolean('type'); // 0 for purchase, 1 for sale
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->string('payment_method');
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
