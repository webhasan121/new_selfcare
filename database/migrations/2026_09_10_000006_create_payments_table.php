<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            // Application-generated reference; available before gateway checkout.
            $table->string('transaction_id', 100)->unique();
            $table->string('gateway_transaction_id', 150)->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method', 30);
            $table->string('status', 20)->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->unique(['payment_method', 'gateway_transaction_id']);
            $table->index(['user_id', 'status', 'created_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

