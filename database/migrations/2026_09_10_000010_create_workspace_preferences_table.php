<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspace_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->restrictOnDelete();
            $table->string('name', 100);
            $table->string('default_view', 20)->default('all');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspace_preferences');
    }
};

