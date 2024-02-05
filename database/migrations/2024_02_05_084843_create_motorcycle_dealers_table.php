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
        Schema::create('dealer_motorcycles', function (Blueprint $table) {
            $table->unsignedBigInteger('motorcycle_id');
            $table->string('dealer_code');
            $table->timestamps();
            $table->foreign('motorcycle_id')->references('id')->on('motorcycles')->onDelete('cascade');
            $table->foreign('dealer_code')->references('dealer_code')->on('dealers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_dealers');
    }
};
