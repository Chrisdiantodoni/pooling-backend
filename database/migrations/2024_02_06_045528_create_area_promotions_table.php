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
        Schema::create('area_promotions', function (Blueprint $table) {
            $table->foreignUuid('promotion_uuid');
            $table->foreignUuid('area_uuid');
            $table->timestamps();

            $table->foreign('promotion_uuid')->references('promotion_uuid')->on('promotions')->onDelete('cascade');
            $table->foreign('area_uuid')->references('area_uuid')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_promotions');
    }
};
