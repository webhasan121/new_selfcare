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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic information
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Authentication
            $table->string('password', 255);
            $table->rememberToken();

            // Contact verification
            $table->string('contact', 20);
            $table->string('contact_verification_hash', 40)->nullable();
            $table->boolean('contact_verified')->default(false);

            // User state
            $table->string('is_token_admin', 1)->nullable();
            $table->integer('active_state')->default(0);

            // Company / profile
            $table->string('company', 35)->default('SAM Online');
            $table->string('message', 250)->nullable();

            // Login tracking
            $table->dateTime('last_login')->nullable();
            $table->string('last_login_ip', 45)->nullable();

            // Personal information
            $table->date('dob')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();

            // Profile
            $table->string('photo', 1024)->nullable();
            $table->text('address')->nullable();
            $table->string('alt_contact', 20)->nullable();

            // API / authentication token
            $table->string('auth_token', 64)->nullable()->unique();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
