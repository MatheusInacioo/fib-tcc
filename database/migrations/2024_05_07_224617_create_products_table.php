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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('brand');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('total_amount');
            $table->integer('minimum_amount');
            $table->string('storage_location');
            $table->longText('description')->nullable();
            $table->longText('additional_info')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
