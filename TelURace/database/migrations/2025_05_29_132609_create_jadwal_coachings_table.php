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
        Schema::create('jadwal_coachings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->constrained('users')->onDelete('cascade');
            $table->foreignId('lombaid')->constrained('lombas')->onDelete('cascade');
            $table->dateTime('tanggal_waktu');
            $table->enum('jenis', ['coaching', 'wawancara']);
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_coachings');
    }
};
