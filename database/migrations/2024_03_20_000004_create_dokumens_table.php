<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id('dokumenid');
            $table->string('namaFile');
            $table->string('jenisdokumen');
            $table->string('statusVerifikasi');
            $table->string('catatan')->nullable();
            $table->string('filepath');
            $table->foreignId('userid')->constrained('users')->onDelete('cascade');
            $table->foreignId('lombaid')->constrained('lombas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
}; 