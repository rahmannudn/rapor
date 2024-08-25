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
        Schema::create('nilai_formatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_guru_mapel_id')->constrained('detail_guru_mapel');
            $table->foreignId('tujuan_pembelajaran_id')->constrained('tujuan_pembelajaran');
            $table->foreignId('kelas_siswa_id')->constrained('kelas_siswa');
            $table->boolean('kktp')->default(false);
            $table->boolean('tampil')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_formatif');
    }
};
