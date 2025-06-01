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
        // No-op: tanggal_waktu is already created in the initial migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: tanggal_waktu is handled by the initial migration
    }
};
