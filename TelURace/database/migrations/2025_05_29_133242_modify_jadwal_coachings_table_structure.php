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
        // First, rename any existing datetime column to tanggal_waktu if it exists
        if (Schema::hasColumn('jadwal_coachings', 'waktu')) {
            Schema::table('jadwal_coachings', function (Blueprint $table) {
                $table->renameColumn('waktu', 'tanggal_waktu');
            });
        } elseif (Schema::hasColumn('jadwal_coachings', 'tanggal')) {
            Schema::table('jadwal_coachings', function (Blueprint $table) {
                $table->renameColumn('tanggal', 'tanggal_waktu');
            });
        } else {
            // If no similar column exists, add the new column
            Schema::table('jadwal_coachings', function (Blueprint $table) {
                $table->dateTime('tanggal_waktu')->after('lombaid')->nullable();
            });
        }

        // Ensure the column is datetime type
        Schema::table('jadwal_coachings', function (Blueprint $table) {
            $table->dateTime('tanggal_waktu')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jadwal_coachings', 'tanggal_waktu')) {
            Schema::table('jadwal_coachings', function (Blueprint $table) {
                $table->dropColumn('tanggal_waktu');
            });
        }
    }
};
