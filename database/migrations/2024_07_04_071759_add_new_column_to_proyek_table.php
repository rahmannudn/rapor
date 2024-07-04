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
        Schema::table('proyek', function (Blueprint $table) {
            $table->foreignId('dimensi_id')->constrained('dimensi');
            $table->foreignId('elemen_id')->constrained('elemen');
            $table->foreignId('subelemen_id')->constrained('subelemen');
            $table->foreignId('capaian_fase_id')->constrained('capaian_fase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyek', function (Blueprint $table) {
            //
        });
    }
};
