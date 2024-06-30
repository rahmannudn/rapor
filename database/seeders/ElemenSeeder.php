<?php

namespace Database\Seeders;

use App\Models\Elemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elemenData = [
            [
                'dimensi_id' => 1,
                'deskripsi' => 'Akhlak Beragama'
            ],
            [
                'dimensi_id' => 1,
                'deskripsi' => 'Akhlak Pribadi'
            ],
            [
                'dimensi_id' => 1,
                'deskripsi' => 'Akhlak Kepada Manusia'
            ],
            [
                'dimensi_id' => 1,
                'deskripsi' => 'Akhlak Kepada Alam'
            ],
            [
                'dimensi_id' => 1,
                'deskripsi' => 'Akhlak Bernegara'
            ],

            [
                'dimensi_id' => 2,
                'deskripsi' => 'Mengenal dan menghargai budaya'
            ],
            [
                'dimensi_id' => 2,
                'deskripsi' => 'Komunikasi dan interaksi antar budaya'
            ],
            [
                'dimensi_id' => 2,
                'deskripsi' => 'Refleksi dan bertanggung jawab terhadap pengalaman kebinekaan'
            ],
            [
                'dimensi_id' => 2,
                'deskripsi' => 'Berkeadilan Sosial'
            ],

            [
                'dimensi_id' => 3,
                'deskripsi' => 'Kolaborasi'
            ],
            [
                'dimensi_id' => 3,
                'deskripsi' => 'Kepedulian'
            ],
            [
                'dimensi_id' => 3,
                'deskripsi' => 'Berbagi'
            ],

            [
                'dimensi_id' => 4,
                'deskripsi' => 'Pemahaman diri dan situasi yang dihadapi'
            ],
            [
                'dimensi_id' => 4,
                'deskripsi' => 'Regulasi Diri'
            ],

            [
                'dimensi_id' => 5,
                'deskripsi' => 'Memperoleh dan memproses informasi dan gagasan'
            ],
            [
                'dimensi_id' => 5,
                'deskripsi' => 'Menganalisis dan mengevaluasi penalaran dan prosedurnya'
            ],
            [
                'dimensi_id' => 5,
                'deskripsi' => 'Refleksi pemikiran dan proses berpikir'
            ],

            [
                'dimensi_id' => 6,
                'deskripsi' => 'Menghasilkan gagasan yang orisinal'
            ],
            [
                'dimensi_id' => 6,
                'deskripsi' => 'Menghasilkan karya dan tindakan yang orisinal'
            ],
            [
                'dimensi_id' => 6,
                'deskripsi' => 'Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan'
            ],
        ];

        foreach ($elemenData as $elemen) {
            Elemen::create(
                $elemen
            );
        }
    }
}
