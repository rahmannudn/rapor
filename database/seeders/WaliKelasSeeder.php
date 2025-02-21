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
                'tahun_ajaran_id' => 1
            ],
            [
                'kelas_id' => 2,
                'user_id' => 2,
                'tahun_ajaran_id' => 1
            ],
        ];

        foreach ($dataWaliKelas as $waliKelas) {
            WaliKelas::create($waliKelas);
        }
    }
}
