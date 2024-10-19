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
        Schema::table('crm_data', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_data', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('shop_id');

            $table->dropColumn(['company_id', 'shop_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('shop_id');

            $table->dropColumn(['company_id', 'shop_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('shop_id');

            $table->dropColumn(['company_id', 'shop_id']);
        });

        Schema::table('suplliers', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('shop_id');

            $table->dropColumn(['company_id', 'shop_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('shop_id');

            $table->dropColumn(['company_id', 'shop_id']);
        });
    }
};
