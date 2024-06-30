<?php

namespace Database\Seeders;

use App\Models\Subelemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubelemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subelemenData = [
            // Dimensi 1 Elemen 1
            [
                'elemen_id' => 1,
                'deskripsi' => 'Mengenal dan Mencintai Tuhan Yang Maha Esa'
            ],
            [
                'elemen_id' => 1,
                'deskripsi' => 'Pemahaman Agama/Kepercayaan'
            ],
            [
                'elemen_id' => 1,
                'deskripsi' => 'Pelaksanaan Ritual Ibadah'
            ],

            // Dimensi 1 Elemen 2
            [
                'elemen_id' => 2,
                'deskripsi' => 'Integritas'
            ],
            [
                'elemen_id' => 2,
                'deskripsi' => 'Merawat Diri secara Fisik, Mental dan Spiritual'
            ],

            // Dimensi 1 Elemen 3
            [
                'elemen_id' => 3,
                'deskripsi' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan'
            ],
            [
                'elemen_id' => 3,
                'deskripsi' => 'Berempati kepada orang lain'
            ],

            // Dimensi 1 Elemen 4            
            [
                'elemen_id' => 4,
                'deskripsi' => 'Memahami Keterhubungan Ekosistem Bumi'
            ],
            [
                'elemen_id' => 4,
                'deskripsi' => 'Menjaga Lingkungan Alam Sekitar'
            ],

            // Dimensi 1 Elemen 5
            [
                'elemen_id' => 5,
                'deskripsi' => 'Melaksanakan Hak dan Kewajiban sebagai Warga Negara Indonesia'
            ],

            // Dimensi 2 Elemen 1
            [
                'elemen_id' => 6,
                'deskripsi' => 'Mendalami budaya dan identitas budaya'
            ],
            [
                'elemen_id' => 6,
                'deskripsi' => 'Mengeksplorasi dan membandingkan pengetahuan budaya, kepercayaan, serta praktiknya'
            ],
            [
                'elemen_id' => 6,
                'deskripsi' => 'Menumbuhkan rasa menghormati terhadap keanekaragaman budaya'
            ],

            // Dimensi 2 Elemen 2
            [
                'elemen_id' => 7,
                'deskripsi' => 'Berkomunikasi antar budaya'
            ],
            [
                'elemen_id' => 7,
                'deskripsi' => 'Mempertimbangkan dan menumbuhkan berbagai perspektif'
            ],

            // Dimensi 2 Elemen 3
            [
                'elemen_id' => 8,
                'deskripsi' => 'Refleksi terhadap pengalaman kebinekaan'
            ],
            [
                'elemen_id' => 8,
                'deskripsi' => 'Menghilangkan stereotip dan prasangka'
            ],
            [
                'elemen_id' => 8,
                'deskripsi' => 'Menyelaraskan perbedaan budaya'
            ],

            // Dimensi 2 Elemen 4
            [
                'elemen_id' => 9,
                'deskripsi' => 'Aktif membangun masyarakat yang inklusif, adil, dan berkelanjutan'
            ],
            [
                'elemen_id' => 9,
                'deskripsi' => 'Berpartisipasi dalam proses pengambilan keputusan bersama'
            ],
            [
                'elemen_id' => 9,
                'deskripsi' => 'Memahami peran individu dalam demokrasi'
            ],

            // Dimensi 3 Elemen 1
            [
                'elemen_id' => 10,
                'deskripsi' => 'Kerja sama'
            ],
            [
                'elemen_id' => 10,
                'deskripsi' => 'Komunikasi untuk mencapai tujuan bersama'
            ],
            [
                'elemen_id' => 10,
                'deskripsi' => 'Saling-ketergantungan positif'
            ],
            [
                'elemen_id' => 10,
                'deskripsi' => 'Koordinasi Sosial'
            ],

            // Dimensi 3 Elemen 2
            [
                'elemen_id' => 11,
                'deskripsi' => 'Tanggap terhadap lingkungan Sosial'
            ],
            [
                'elemen_id' => 11,
                'deskripsi' => 'Persepsi sosial'
            ],

            // Dimensi 3 Elemen 3
            [
                'elemen_id' => 12,
                'deskripsi' => 'Berbagi'
            ],

            // Dimensi 4 Elemen 1
            [
                'elemen_id' => 13,
                'deskripsi' => 'Mengenali kualitas dan minat diri serta tantangan yang dihadapi'
            ],
            [
                'elemen_id' => 13,
                'deskripsi' => 'Mengembangkan refleksi diri'
            ],

            // Dimensi 4 Elemen 2
            [
                'elemen_id' => 14,
                'deskripsi' => 'Regulasi emosi'
            ],
            [
                'elemen_id' => 14,
                'deskripsi' => 'Penetapan tujuan belajar, prestasi, dan pengembangan diri serta rencana strategis untuk mencapainya'
            ],
            [
                'elemen_id' => 14,
                'deskripsi' => 'Menunjukkan inisiatif dan bekerja secara mandiri'
            ],
            [
                'elemen_id' => 14,
                'deskripsi' => 'Mengembangkan pengendalian dan disiplin diri'
            ],
            [
                'elemen_id' => 14,
                'deskripsi' => 'Percaya diri, tangguh (resilient), dan adaptif'
            ],

            // Dimensi 5 Elemen 1
            [
                'elemen_id' => 15,
                'deskripsi' => 'Mengajukan pertanyaan'
            ],
            [
                'elemen_id' => 15,
                'deskripsi' => 'Mengidentifikasi, mengklarifikasi, dan mengolah informasi dan gagasan'
            ],

            // Dimensi 5 Elemen 2
            [
                'elemen_id' => 16,
                'deskripsi' => 'Menganalisis dan mengevaluasi penalaran dan prosedurnya'
            ],

            // Dimensi 5 Elemen 3
            [
                'elemen_id' => 17,
                'deskripsi' => 'Merefleksi dan mengevaluasi pemikirannya sendiri'
            ],

            // Dimensi 6 Elemen 1
            [
                'elemen_id' => 18,
                'deskripsi' => 'Menghasilkan gagasan yang orisinal'
            ],

            // Dimensi 6 Elemen 2
            [
                'elemen_id' => 19,
                'deskripsi' => 'Menghasilkan karya dan tindakan yang orisinal'
            ],

            // Dimensi 6 Elemen 3
            [
                'elemen_id' => 20,
                'deskripsi' => 'Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan'
            ],
        ];

        foreach ($subelemenData as $subelemen) {
            Subelemen::create(
                $subelemen
            );
        }
    }
}
