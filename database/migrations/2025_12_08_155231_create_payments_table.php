<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_payments_table.php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // This column is required for your query: Payment::where('payment_intent_id', $paymentId)
            $table->string('payment_intent_id')->unique()->nullable();
            $table->string('status')->default('pending');
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3)->default('usd');
            $table->string('email')->nullable();
            // You might need a foreign key to link the payment to a user or an order
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
