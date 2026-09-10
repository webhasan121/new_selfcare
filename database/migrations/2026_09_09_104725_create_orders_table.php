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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->string('email', 30);
            $table->string('phone', 20);

            $table->decimal('amount', 12, 2);

            $table->text('address')->nullable();

            $table->string('status', 10);
            $table->string('transaction_id');
            $table->string('currency', 20);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
