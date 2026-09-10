<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->restrictOnDelete();
            $table->foreignId('invoice_id')->constrained('invoices')->restrictOnDelete();
            $table->decimal('amount', 12, 2);
            $table->unique(['payment_id', 'invoice_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_items');
    }
};

