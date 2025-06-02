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
        // Only modify the column type if the column exists
        if (Schema::hasColumn('jadwal_coachings', 'tanggal_waktu')) {
            Schema::table('jadwal_coachings', function (Blueprint $table) {
                $table->dateTime('tanggal_waktu')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No specific action needed for down migration
        // The column will be handled by the main table migration
    }
};
