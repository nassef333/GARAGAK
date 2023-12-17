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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_id')->constrained('garages');
            $table->foreignId('car_users_id')->constrained('car_user');
            $table->foreignId('slot_id')->constrained('slots');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->timestamp('entered_at');
            $table->timestamp('leaved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
