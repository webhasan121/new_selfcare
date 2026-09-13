<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('workspace_preferences');
    }

    public function down(): void
    {
        // The retired module is intentionally not restored by rollback.
    }
};
