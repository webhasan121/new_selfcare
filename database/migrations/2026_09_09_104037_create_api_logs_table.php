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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('ref', 50)->nullable();
            $table->string('url', 512)->nullable();

            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->text('additional_data')->nullable();

            $table->string('status_code', 20)->nullable();
            $table->string('status_name', 50)->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
