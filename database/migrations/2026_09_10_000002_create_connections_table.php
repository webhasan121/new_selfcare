<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('name', 100);
            $table->string('type', 30)->default('home');
            $table->text('installation_address')->nullable();
            $table->string('status', 20)->default('pending');
            $table->index(['user_id', 'status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};

