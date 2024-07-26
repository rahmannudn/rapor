<?php

namespace Database\Seeders;

use App\Models\Subproyek;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubproyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataSubproyek = [
            [
                'proyek_id' => 1,
                'capaian_fase_id' => 20,
            ],
            [
                'proyek_id' => 1,
                'capaian_fase_id' => 25,
            ],
            [
                'proyek_id' => 1,
                'capaian_fase_id' => 45,
            ],
            [
                'proyek_id' => 1,
                'capaian_fase_id' => 15,
            ],
            [
                'proyek_id' => 1,
                'capaian_fase_id' => 8,
            ],
            [
                'proyek_id' => 2,
                'capaian_fase_id' => 15,
            ],
            [
                'proyek_id' => 2,
                'capaian_fase_id' => 5,
            ],
        ];

        foreach ($dataSubproyek as $subproyek) {
            Subproyek::create($subproyek);
        }
    }
}
