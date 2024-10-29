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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['Cartão', 'Boleto', 'Transferência', 'Dinheiro', 'Pix']);
            $table->enum('recurrence', ['Única', 'Mensal', 'Anual']);
            $table->string('department')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('pending')->default(true);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
