<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usage_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('connection_id')->constrained('connections')->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->index(['user_id', 'created_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_reports');
    }
};

