<?php

namespace Database\Seeders;

use App\Models\DetailGuruMapel;
use App\Models\GuruMapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $guruMapel = [
            [
                'user_id' => 3,
                'tahun_ajaran_id' => 2
            ],
            [
                'user_id' => 4,
                'tahun_ajaran_id' => 2
            ],
        ];

        $detailGuruMapel = [
            [
                'guru_mapel_id' => 1,
                'mapel_id' => 1,
                'kelas_id' => 1
            ],
            [
                'guru_mapel_id' => 2,
                'mapel_id' => 3,
                'kelas_id' => 1
            ],
            [
                'guru_mapel_id' => 2,
                'mapel_id' => 2,
                'kelas_id' => 2
            ],
            [
                'guru_mapel_id' => 1,
                'mapel_id' => 4,
                'kelas_id' => 1
            ]
        ];

        foreach ($guruMapel as $guru) {
            GuruMapel::create($guru);
        }

        foreach ($detailGuruMapel as $guru) {
            DetailGuruMapel::create($guru);
        }
    }
}
