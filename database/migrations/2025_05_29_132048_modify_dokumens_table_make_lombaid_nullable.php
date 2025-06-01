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
        Schema::table('dokumens', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['lombaid']);
            
            // Modify the column to be nullable
            $table->foreignId('lombaid')->nullable()->change();
            
            // Add the foreign key constraint back with nullable option
            $table->foreign('lombaid')->references('id')->on('lombas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            // Drop the nullable foreign key constraint
            $table->dropForeign(['lombaid']);
            
            // Make the column required again
            $table->foreignId('lombaid')->nullable(false)->change();
            
            // Add back the original foreign key constraint
            $table->foreign('lombaid')->references('id')->on('lombas');
        });
    }
};
