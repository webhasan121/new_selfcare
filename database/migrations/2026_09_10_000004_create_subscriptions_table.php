<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('connection_id')->constrained('connections')->restrictOnDelete();
            $table->foreignId('package_id')->constrained('packages')->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 20)->default('pending');
            $table->index(['connection_id', 'status', 'end_date']);
            // Supports the invoice foreign key enforcing the same connection.
            $table->unique(['id', 'connection_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

