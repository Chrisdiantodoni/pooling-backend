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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip')->nullable();
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('username')->unique();
            $table->string('address')->nullable();
            $table->string('birth_address')->nullable();
            $table->date('birth_of_date')->nullable();
            $table->date('date_started_work')->nullable();
            $table->foreignId('Dealer_code')->nullable();
            $table->foreignId('area_id')->nullable();
            $table->string('department')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->dateTime('password_changed_at')->nullable();
            $table->string('password');
            $table->date('non_active_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
