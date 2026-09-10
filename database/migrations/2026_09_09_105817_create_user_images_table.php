<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->string('type', 50);
            $table->string('path', 150)->nullable();
            $table->string('file_name', 150);
            $table->string('data', 150)->nullable();

            $table->boolean('is_active');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_images');
    }
};
