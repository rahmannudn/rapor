<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMapel = [
            [
                'nama_mapel' => 'Matematika',
            ],
            [
                'nama_mapel' => 'Bahasa Indonesia',
            ],
            [
                'nama_mapel' => 'Seni Budaya',
            ],
            [
                'nama_mapel' => 'Agama Islam',
            ],
        ];

        foreach ($dataMapel as $mapel) {
            Mapel::create(
                $mapel
            );
        }
    }
}
