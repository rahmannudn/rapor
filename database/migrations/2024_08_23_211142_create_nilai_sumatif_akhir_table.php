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
        Schema::create('nilai_sumatif_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_guru_mapel_id')->constrained('detail_guru_mapel');
            $table->foreignId('rapor_id')->constrained('rapor');
            $table->string('nilai_nontes', 3)->nullable();
            $table->string('nilai_tes', 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sumatif_akhir');
    }
};
