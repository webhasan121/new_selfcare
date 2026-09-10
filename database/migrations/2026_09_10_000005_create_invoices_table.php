<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('connection_id')->constrained('connections')->restrictOnDelete();
            // Nullable for installation fees and other charges without a subscription.
            $table->foreignId('subscription_id')->nullable();
            $table->string('invoice_number', 64)->unique();
            $table->decimal('amount', 12, 2);
            $table->date('due_date');
            $table->string('status', 20)->default('unpaid');
            $table->index(['connection_id', 'status', 'due_date']);
            $table->foreign(['subscription_id', 'connection_id'])
                ->references(['id', 'connection_id'])->on('subscriptions')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

