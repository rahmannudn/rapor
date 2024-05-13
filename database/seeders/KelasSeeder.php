<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKelas = [
            [
                'kelas' => '1',
                'nama' => 'Kelas 1',
                'fase' => 'a'
            ],
            [
                'kelas' => '2',
                'nama' => 'Kelas 2a',
                'fase' => 'a'
            ],
            [
                'kelas' => '2',
                'nama' => 'Kelas 2b',
                'fase' => 'a'
            ],
        ];

        foreach ($dataKelas as $kelas) {
            Kelas::create(
                $kelas
            );
        }
    }
}
