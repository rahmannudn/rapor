<?php

namespace Database\Seeders;

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
                'tahun' => '2023 / 2024',
                'semester' => 'ganjil',
                'aktif' => 0
            ],
            [
                'tahun' => '2023 / 2024',
                'semester' => 'genap',
                'aktif' => 1
            ],
        ];

        foreach ($dataTahunAjaran as $tahunAjaran) {
            TahunAjaran::create(
                $tahunAjaran
            );
        }
    }
}
