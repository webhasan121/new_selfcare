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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();

            $table->string('company_name', 150);
            $table->string('contact_person', 100);
            $table->string('address', 200);
            $table->string('display_name', 30);

            $table->date('fy_start_date');
            $table->integer('billing_policy');

            $table->string('address_line1', 150)->nullable();
            $table->string('address_line2', 150)->nullable();
            $table->string('address_line3', 150)->nullable();

            $table->string('email', 50)->nullable();
            $table->string('web', 50)->nullable();
            $table->string('contact', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
