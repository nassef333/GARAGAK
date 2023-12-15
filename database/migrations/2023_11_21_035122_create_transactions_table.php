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
            $table->foreignId('garage_id')->constrained('garages');
            $table->decimal('total_price');
            $table->string('merchantRefNumber');
            $table->string('merchantNumber');
            $table->timestamp('payment_expiry');
            $table->string('status');
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_method');
            $table->string('customer_profile_id');
            $table->string('signature');
            $table->timestamps();
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
