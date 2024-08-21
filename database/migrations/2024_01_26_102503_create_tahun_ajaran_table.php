<?php

use App\Models\TahunAjaran;
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
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prev_tahun_ajaran_id')->nullable()->constrained('tahun_ajaran');
            $table->string('tahun');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->boolean('aktif')->nullable('false');
            $table->date('tgl_rapor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};
