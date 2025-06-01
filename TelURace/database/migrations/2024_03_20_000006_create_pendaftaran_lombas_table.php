<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_lombas', function (Blueprint $table) {
            $table->id('pendaftaranid');
            $table->foreignId('mahasiswaid')->constrained('mahasiswas', 'nim');
            $table->foreignId('lombaid')->constrained('lombas');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_lombas');
    }
}; 