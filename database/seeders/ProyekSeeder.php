<?php

namespace Database\Seeders;

use App\Models\Proyek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataProyek = [
            [
                'wali_kelas_id' => 2,
                'judul_proyek' => 'meningkatkan kemampuan berhitung siswa',
                'deskripsi' => 'asdjasiodjsd'
            ],
            [
                'wali_kelas_id' => 2,
                'judul_proyek' => 'menanamkan rasa cinta lingkungan',
                'deskripsi' => 'asdjasiodjsd'
            ],
            [
                'wali_kelas_id' => 1,
                'judul_proyek' => 'meningkatkan rasa percaya diri siswa',
                'deskripsi' => 'oiojasdkasdjisad'
            ],
        ];

        foreach ($dataProyek as $proyek) {
            Proyek::create($proyek);
        }
    }
}
