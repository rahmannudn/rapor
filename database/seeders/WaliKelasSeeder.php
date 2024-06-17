<?php

namespace Database\Seeders;

use App\Models\WaliKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataWaliKelas = [
            [
                'kelas_id' => 1,
                'user_id' => 3,
                'tahun_ajaran_id' => 2
            ],
            [
                'kelas_id' => 2,
                'user_id' => 4,
                'tahun_ajaran_id' => 2
            ],
            [
                'kelas_id' => 3,
                'user_id' => 4,
                'tahun_ajaran_id' => 2
            ],
            [
                'kelas_id' => 4,
                'user_id' => 3,
                'tahun_ajaran_id' => 2
            ]
        ];

        foreach ($dataWaliKelas as $waliKelas) {
            WaliKelas::create($waliKelas);
        }
    }
}
