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
        Schema::create('crm_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crm_id');
            $table->longText('description');
            $table->string('user');
            $table->timestamps();

            $table->foreign('crm_id')->references('id')->on('crm_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_attendances');
    }
};
