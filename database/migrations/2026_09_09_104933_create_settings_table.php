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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('category', 50)->nullable();
            $table->string('sub_category', 50)->nullable();
            $table->string('name');

            $table->enum('type', [
                'raw',
                'bool',
                'int',
                'float',
                'serialize',
                'json',
                'html',
                'delimited',
                'reference',
            ])->default('raw');

            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
