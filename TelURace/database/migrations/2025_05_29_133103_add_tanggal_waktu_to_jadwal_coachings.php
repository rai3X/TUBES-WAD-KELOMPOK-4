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
        Schema::table('jadwal_coachings', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_coachings', 'tanggal_waktu')) {
                $table->dateTime('tanggal_waktu')->after('lombaid');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_coachings', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_coachings', 'tanggal_waktu')) {
                $table->dropColumn('tanggal_waktu');
            }
        });
    }
};
