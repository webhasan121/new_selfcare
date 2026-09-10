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
        Schema::create('sms', function (Blueprint $table) {
            $table->id();

            $table->integer('enable_sms')->default(0);

            $table->string('userID', 50)->nullable();
            $table->string('passwd', 200)->nullable();

            $table->integer('sms_local_mr_entry')->default(0);
            $table->integer('sms_corporate_mr_entry')->default(0);
            $table->integer('sms_customer_create')->default(0);

            $table->integer('sms_local_bill_gen')->default(0);
            $table->integer('sms_corporate_bill_gen')->default(0);

            $table->integer('sms_local_other_bill_entry')->default(0);
            $table->integer('sms_corporate_other_bill_entry')->default(0);

            $table->integer('sms_token_create')->default(0);
            $table->integer('sms_token_close')->default(0);

            $table->string('masking', 50)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('service_provider', 50);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms');
    }
};
