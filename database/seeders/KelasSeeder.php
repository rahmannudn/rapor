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
            [
                'kelas' => '3',
                'nama' => 'Kelas 3',
                'fase' => 'a'
            ],
            [
                'kelas' => '4',
                'nama' => 'Kelas 4',
                'fase' => 'b'
            ],
            [
                'kelas' => '5',
                'nama' => 'Kelas 5',
                'fase' => 'b'
            ],
            [
                'kelas' => '6',
                'nama' => 'Kelas 6',
                'fase' => 'b'
            ],
        ];

        foreach ($dataKelas as $kelas) {
            Kelas::create(
                $kelas
            );
        }
    }
}
