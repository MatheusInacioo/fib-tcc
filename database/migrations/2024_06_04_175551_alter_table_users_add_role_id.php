<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('id');
            $table->unsignedBigInteger('company_id')->nullable()->after('remember_token');
            $table->unsignedBigInteger('shop_id')->nullable()->after('company_id');
            $table->boolean('active')->after('shop_id');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'company_id', 'shop_id', 'active']);
        });
    }
};
