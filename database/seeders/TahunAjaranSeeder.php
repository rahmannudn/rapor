<?php

namespace Database\Seeders;

use App\Models\Kepsek;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataTahunAjaran = [
            [
                'tahun' => '2024 / 2025',
                'semester' => 'ganjil',
                'aktif' => 1,
                'kepsek_id' => 1
            ],
        ];

        foreach ($dataTahunAjaran as $tahunAjaran) {
            TahunAjaran::create(
                $tahunAjaran
            );
        }
    }
}
