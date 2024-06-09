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
        Schema::create('materi_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_guru_mapel_id')->constrained(table: 'detail_guru_mapel');
            $table->text('tujuan_pembelajaran');
            $table->string('lingkup_materi', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_mapel');
    }
};
