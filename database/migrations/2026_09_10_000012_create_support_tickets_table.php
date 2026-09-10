<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('connection_id')->constrained('connections')->restrictOnDelete();
            $table->string('subject', 150);
            $table->string('category', 30);
            $table->text('description');
            $table->string('status', 20)->default('open');
            $table->index(['user_id', 'status', 'created_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};

