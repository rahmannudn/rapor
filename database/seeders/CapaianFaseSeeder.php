<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapaianFaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataCapaian = [
            // Mengenal dan Mencintai Tuhan Yang Maha Esa
            [
                'subelemen_id' => 1,
                'fase' => 'a',
                'deskripsi' => 'Mengenali sifat-sifat utama Tuhan bahwa Ia Maha Esa dan Ia adalah Sang Pencipta yang Maha Pengasih dan Maha Penyayang dan mengenali kebaikan dirinya sebagai cerminan sifat Tuhan'
            ],
            [
                'subelemen_id' => 1,
                'fase' => 'b',
                'deskripsi' => 'Memahami sifat-sifat Tuhan utama lainnya dan mengaitkan sifatsifat tersebut dengan konsep dirinya dan ciptaan-Nya'
            ],
            [
                'subelemen_id' => 1,
                'fase' => 'c',
                'deskripsi' => 'Memahami kehadiran Tuhan dalam kehidupan sehari-hari serta mengaitkan pemahamannya tentang kualitas atau sifat-sifat Tuhan dengan konsep peran manusia di bumi sebagai makhluk Tuhan yang bertanggung jawab.'
            ],

            // Pemahaman Agama/Kepercayaan
            [
                'subelemen_id' => 2,
                'fase' => 'a',
                'deskripsi' => 'Mengenali unsur-unsur utama agama/kepercayaan (ajaran, ritual keagamaan, kitab suci, dan orang suci/ utusan Tuhan YME).'
            ],
            [
                'subelemen_id' => 2,
                'fase' => 'b',
                'deskripsi' => 'Mengenali unsur-unsur utama agama/kepercayaan (simbol-simbol keagamaan dan sejarah agama/ kepercayaan).'
            ],
            [
                'subelemen_id' => 2,
                'fase' => 'c',
                'deskripsi' => 'Memahami unsur-unsur utama agama/kepercayaan, dan mengenali peran agama/kepercayaan dalam kehidupan serta memahami ajaran moral agama.'
            ],

            // Pelaksanaan Ritual Ibadah
            [
                'subelemen_id' => 3,
                'fase' => 'a',
                'deskripsi' => 'Terbiasa melaksanakan ibadah sesuai ajaran agama/kepercayaannya'
            ],
            [
                'subelemen_id' => 3,
                'fase' => 'b',
                'deskripsi' => 'Terbiasa melaksanakan ibadah wajib sesuai tuntunan agama/kepercayaannya'
            ],
            [
                'subelemen_id' => 3,
                'fase' => 'c',
                'deskripsi' => 'Melaksanakan ibadah secara rutin sesuai dengan tuntunan agama/kepercayaan, berdoa mandiri, merayakan, dan memahami makna hari-hari besarnya'
            ],

            // Integritas
            [
                'subelemen_id' => 4,
                'fase' => 'a',
                'deskripsi' => 'Membiasakan bersikap jujur terhadap diri sendiri dan orang lain dan berani menyampaikan kebenaran atau fakta'
            ],
            [
                'subelemen_id' => 4,
                'fase' => 'b',
                'deskripsi' => 'Membiasakan melakukan refleksi tentang pentingnya bersikap jujur dan berani menyampaikan kebenaran atau fakta'
            ],
            [
                'subelemen_id' => 4,
                'fase' => 'c',
                'deskripsi' => 'Berani dan konsisten menyampaikan kebenaran atau fakta serta memahami konsekuensi-konsekuensinya untuk diri sendiri'
            ],

            // Merawat Diri secara Fisik, Mental dan Spiritual
            [
                'subelemen_id' => 5,
                'fase' => 'a',
                'deskripsi' => ' Memiliki rutinitas sederhana yang diatur secara mandiri dan dijalankan sehari-hari serta menjaga kesehatan dan keselamatan/keamanan diri dalam semua aktivitas kesehariannya.'
            ],
            [
                'subelemen_id' => 5,
                'fase' => 'b',
                'deskripsi' => 'Mulai membiasakan diri untuk disiplin, rapi, membersihkan dan merawat tubuh, menjaga tingkah laku dan perkataan dalam semua aktivitas kesehariannya'
            ],
            [
                'subelemen_id' => 5,
                'fase' => 'c',
                'deskripsi' => 'Memperhatikan kesehatan jasmani, mental, dan rohani dengan melakukan aktivitas fisik, sosial, dan ibadah.'
            ],

            // Mengutamakan persamaan dengan orang lain dan menghargai perbedaan
            [
                'subelemen_id' => 6,
                'fase' => 'a',
                'deskripsi' => 'Mengenali hal-hal yang sama dan berbeda yang dimiliki diri dan temannya dalam berbagai hal, serta memberikan respon secara positif.'
            ],
            [
                'subelemen_id' => 6,
                'fase' => 'b',
                'deskripsi' => 'Terbiasa mengidentifikasi hal-hal yang sama dan berbeda yang dimiliki diri dan temannya dalam berbagai hal serta memberikan respon secara positif.'
            ],
            [
                'subelemen_id' => 6,
                'fase' => 'c',
                'deskripsi' => 'Mengidentifikasi kesamaan dengan orang lain sebagai perekat hubungan sosial dan mewujudkannya dalam aktivitas kelompok. Mulai mengenal berbagai kemungkinan interpretasi dan cara pandang yang berbeda ketika dihadapkan dengan dilema.'
            ],

            // Berempati kepada orang lain
            [
                'subelemen_id' => 7,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi emosi, minat dan kebutuhan orang-orang terdekat dan meresponnya secara positif.'
            ],
            [
                'subelemen_id' => 7,
                'fase' => 'b',
                'deskripsi' => 'Terbiasa memberikan apresiasi di lingkungan sekolah dan masyarakat.'
            ],
            [
                'subelemen_id' => 7,
                'fase' => 'c',
                'deskripsi' => 'Mulai memandang sesuatu dari perspektif orang lain serta mengidentifikasi kebaikan dan kelebihan orang sekitarnya.'
            ],

            // Memahami Keterhubungan Ekosistem Bumi
            [
                'subelemen_id' => 8,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi berbagai ciptaan Tuhan.'
            ],
            [
                'subelemen_id' => 8,
                'fase' => 'b',
                'deskripsi' => 'Memahami keterhubungan antara satu ciptaan dengan ciptaan Tuhan yang lainnya.'
            ],
            [
                'subelemen_id' => 8,
                'fase' => 'c',
                'deskripsi' => 'Memahami konsep harmoni dan mengidentifikasi adanya saling ketergantungan antara berbagai ciptaan Tuhan.'
            ],

            // Menjaga Lingkungan Alam Sekitar
            [
                'subelemen_id' => 9,
                'fase' => 'a',
                'deskripsi' => 'Membiasakan bersyukur atas lingkungan alam sekitar dan berlatih untuk menjaganya.'
            ],
            [
                'subelemen_id' => 9,
                'fase' => 'b',
                'deskripsi' => 'Terbiasa memahami tindakan-tindakan yang ramah dan tidak ramah lingkungan serta membiasakan diri untuk berperilaku ramah lingkungan.'
            ],
            [
                'subelemen_id' => 9,
                'fase' => 'c',
                'deskripsi' => 'Mewujudkan rasa syukur dengan terbiasa berperilaku ramah lingkungan dan memahami akibat perbuatan tidak ramah lingkungan dalam lingkup kecil maupun besar.'
            ],

            // Melaksanakan Hak dan Kewajiban sebagai Warga Negara Indonesia
            [
                'subelemen_id' => 10,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi hak dan tanggung jawabnya di rumah, sekolah, dan lingkungan sekitar serta kaitannya dengan keimanan kepada Tuhan YME.'
            ],
            [
                'subelemen_id' => 10,
                'fase' => 'b',
                'deskripsi' => 'Mengidentifikasi hak dan tanggung jawab orang-orang di sekitarnya serta kaitannya dengan keimanan kepada Tuhan YME.'
            ],
            [
                'subelemen_id' => 10,
                'fase' => 'c',
                'deskripsi' => 'Mengidentifikasi dan memahami peran, hak, dan kewajiban dasar sebagai warga negara serta kaitannya dengan keimanan kepada Tuhan YME dan secara sadar mempraktikkannya dalam kehidupan sehari-hari.'
            ],

            // Mendalami budaya dan identitas budaya
            [
                'subelemen_id' => 11,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi dan mendeskripsikan ide-ide tentang dirinya dan beberapa macam kelompok di lingkungan sekitarnya.'
            ],
            [
                'subelemen_id' => 11,
                'fase' => 'b',
                'deskripsi' => 'Mengidentifikasi dan mendeskripsikan ide-ide tentang dirinya dan berbagai macam kelompok di lingkungan sekitarnya, serta cara orang lain berperilaku dan berkomunikasi dengannya.'
            ],
            [
                'subelemen_id' => 11,
                'fase' => 'c',
                'deskripsi' => 'Mengidentifikasi dan mendeskripsikan keragaman budaya di sekitarnya; serta menjelaskan peran budaya dan Bahasa dalam membentuk identitas dirinya.'
            ],

            // Mengeksplorasi dan membandingkan pengetahuan budaya, kepercayaan, serta praktiknya
            [
                'subelemen_id' => 12,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi dan mendeskripsikan praktik keseharian diri dan budayanya.'
            ],
            [
                'subelemen_id' => 12,
                'fase' => 'b',
                'deskripsi' => 'Mengidentifikasi dan membandingkan praktik keseharian diri dan budayanya dengan orang lain di tempat dan waktu/era yang berbeda.'
            ],
            [
                'subelemen_id' => 12,
                'fase' => 'c',
                'deskripsi' => 'Mendeskripsikan dan membandingkan pengetahuan, kepercayaan, dan praktik dari berbagai kelompok budaya.'
            ],

            // Menumbuhkan rasa menghormati terhadap keanekaragaman budaya
            [
                'subelemen_id' => 13,
                'fase' => 'a',
                'deskripsi' => 'Mendeskripsikan pengalaman dan pemahaman hidup bersama-sama dalam kemajemukan.'
            ],
            [
                'subelemen_id' => 13,
                'fase' => 'b',
                'deskripsi' => 'Memahami bahwa kemajemukan dapat memberikan kesempatan untuk mendapatkan pengalaman dan pemahaman yang baru.'
            ],
            [
                'subelemen_id' => 13,
                'fase' => 'c',
                'deskripsi' => 'Mengidentifikasi peluang dan tantangan yang muncul dari keragaman budaya di Indonesia.'
            ],

            // Berkomunikasi antar budaya
            [
                'subelemen_id' => 14,
                'fase' => 'a',
                'deskripsi' => 'Mengenali bahwa diri dan orang lain menggunakan kata, gambar, dan bahasa tubuh yang dapat memiliki makna yang berbeda di lingkungan sekitarnya.'
            ],
            [
                'subelemen_id' => 14,
                'fase' => 'b',
                'deskripsi' => 'Mendeskripsikan penggunaan kata, tulisan dan bahasa tubuh yang memiliki makna yang berbeda di lingkungan sekitarnya dan dalam suatu budaya tertentu.'
            ],
            [
                'subelemen_id' => 14,
                'fase' => 'c',
                'deskripsi' => 'Memahami persamaan dan perbedaan cara komunikasi baik di dalam maupun antar kelompok budaya.'
            ],

            // Mempertimbangkan dan menumbuhkan berbagai perspektif
            [
                'subelemen_id' => 15,
                'fase' => 'a',
                'deskripsi' => 'Mengekspresikan pandangannya terhadap topik yang umum dan mendengarkan sudut pandang orang lain yang berbeda dari dirinya dalam lingkungan keluarga dan sekolah.'
            ],
            [
                'subelemen_id' => 15,
                'fase' => 'b',
                'deskripsi' => 'Mengekspresikan pandangannya terhadap topik yang umum dan dapat mengidentifikasi sudut pandang orang lain. Mendengarkan dan membayangkan sudut pandang orang lain yang berbeda dari dirinya pada situasi di ranah sekolah, keluarga, dan lingkungan sekitar.'
            ],
            [
                'subelemen_id' => 15,
                'fase' => 'c',
                'deskripsi' => 'Membandingkan beragam perspektif untuk memahami permasalahan sehari-hari. Membayangkan dan mendeskripsikan situasi komunitas yang berbeda dengan dirinya ke dalam situasi dirinya dalam konteks lokal dan regional.'
            ],

            // Refleksi terhadap pengalaman kebinekaan
            [
                'subelemen_id' => 16,
                'fase' => 'a',
                'deskripsi' => 'Menyebutkan apa yang telah dipelajari tentang orang lain dari interaksinya dengan kemajemukan budaya di lingkungan sekolah dan rumah.'
            ],
            [
                'subelemen_id' => 16,
                'fase' => 'b',
                'deskripsi' => 'Menyebutkan apa yang telah dipelajari tentang orang lain dari interaksinya dengan kemajemukan budaya di lingkungan sekitar.'
            ],
            [
                'subelemen_id' => 16,
                'fase' => 'c',
                'deskripsi' => 'Menjelaskan apa yang telah dipelajari dari interaksi dan pengalaman dirinya dalam lingkungan yang beragam.'
            ],

            // Menghilangkan stereotip dan prasangka
            [
                'subelemen_id' => 17,
                'fase' => 'a',
                'deskripsi' => 'Mengenali perbedaan tiap orang atau kelompok dan menganggapnya sebagai kewajaran.'
            ],
            [
                'subelemen_id' => 17,
                'fase' => 'b',
                'deskripsi' => 'Mengkonfirmasi dan mengklarifikasi stereotip dan prasangka yang dimilikinya tentang orang atau kelompokdi sekitarnya untuk mendapatkan pemahaman yang lebih baik.'
            ],
            [
                'subelemen_id' => 17,
                'fase' => 'c',
                'deskripsi' => 'Mengkonfirmasi dan mengklarifikasi stereotip dan prasangka yang dimilikinya tentang orang atau kelompok di sekitarnya untuk mendapatkan pemahaman yang lebih baik serta mengidentifikasi pengaruhnya terhadap individu dan kelompok di lingkungan sekitarnya.'
            ],

            // Menyelaraskan perbedaan budaya
            [
                'subelemen_id' => 18,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi perbedaan-perbedaan budaya yang konkrit di lingkungan sekitar.'
            ],
            [
                'subelemen_id' => 18,
                'fase' => 'b',
                'deskripsi' => 'Mengenali bahwa perbedaan budaya mempengaruhi pemahaman antarindividu.'
            ],
            [
                'subelemen_id' => 18,
                'fase' => 'c',
                'deskripsi' => 'Mencari titik temu nilai budaya yang beragam untuk menyelesaikan permasalahan bersama.'
            ],

            // Aktif membangun masyarakat yang inklusif, adil, dan berkelanjutan
            [
                'subelemen_id' => 19,
                'fase' => 'a',
                'deskripsi' => 'Menjalin pertemanan tanpa memandang perbedaan agama, suku, ras, jenis kelamin, dan perbedaan lainnya, dan mengenal masalah-masalah sosial, ekonomi, dan lingkungan di lingkungan sekitarnya.'
            ],
            [
                'subelemen_id' => 19,
                'fase' => 'b',
                'deskripsi' => 'Mengidentifikasi cara berkontribusi terhadap lingkungan sekolah, rumah dan lingkungan sekitarnya yang inklusif, adil dan berkelanjutan.'
            ],
            [
                'subelemen_id' => 19,
                'fase' => 'c',
                'deskripsi' => 'Membandingkan beberapa tindakan dan praktik perbaikan lingkungan sekolah yang inklusif, adil, dan berkelanjutan, dengan mempertimbangkan dampaknya secara jangka panjang terhadap manusia, alam, dan masyarakat.'
            ],

            // Berpartisipasi dalam proses pengambilan keputusan bersama
            [
                'subelemen_id' => 20,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi pilihan-pilihan berdasarkan kebutuhan dirinya dan orang lain ketika membuat keputusan.'
            ],
            [
                'subelemen_id' => 20,
                'fase' => 'b',
                'deskripsi' => 'Berpartisipasi menentukan beberapa pilihan untuk keperluan bersama berdasarkan kriteria sederhana.'
            ],
            [
                'subelemen_id' => 20,
                'fase' => 'c',
                'deskripsi' => 'Berpartisipasi dalam menentukan kriteria yang disepakati bersama untuk menentukan pilihan dan keputusan untuk kepentingan bersama.'
            ],

            // Memahami peran individu dalam demokrasi
            [
                'subelemen_id' => 21,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi peran, hak dan kewajiban warga dalam masyarakat demokratis.'
            ],
            [
                'subelemen_id' => 21,
                'fase' => 'b',
                'deskripsi' => 'Memahami konsep hak dan kewajiban, serta implikasinya terhadap perilakunya.'
            ],
            [
                'subelemen_id' => 21,
                'fase' => 'c',
                'deskripsi' => 'Memahami konsep hak dan kewajiban, serta implikasinya terhadap perilakunya. Menggunakan konsep ini untuk menjelaskan perilaku diri dan orang sekitarnya.'
            ],

            // Kerja sama
            [
                'subelemen_id' => 22,
                'fase' => 'a',
                'deskripsi' => 'Menerima dan melaksanakan tugas serta peran yang diberikan kelompok dalam sebuah kegiatan bersama.'
            ],
            [
                'subelemen_id' => 22,
                'fase' => 'b',
                'deskripsi' => 'Menampilkan tindakan yang sesuai dengan harapan dan tujuan kelompok.'
            ],
            [
                'subelemen_id' => 22,
                'fase' => 'c',
                'deskripsi' => 'Menunjukkan ekspektasi (harapan) positif kepada orang lain dalam rangka mencapai tujuan kelompok di lingkungan sekitar (sekolah dan rumah).'
            ],

            // Komunikasi untuk mencapai tujuan bersama
            [
                'subelemen_id' => 23,
                'fase' => 'a',
                'deskripsi' => 'Memahami informasi sederhana dari orang lain dan menyampaikan informasi sederhana kepada orang lain menggunakan kata-katanya sendiri.'
            ],
            [
                'subelemen_id' => 23,
                'fase' => 'b',
                'deskripsi' => 'Memahami informasi yang disampaikan (ungkapan pikiran, perasaan, dan keprihatinan) orang lain dan menyampaikan informasi secara akurat menggunakan berbagai simbol dan media.'
            ],
            [
                'subelemen_id' => 23,
                'fase' => 'c',
                'deskripsi' => 'Memahami informasi dari berbagai sumber dan menyampaikan pesan menggunakan berbagai simbol dan media secara efektif kepada orang lain untuk mencapai tujuan bersama.'
            ],

            // Saling-ketergantungan positif
            [
                'subelemen_id' => 24,
                'fase' => 'a',
                'deskripsi' => 'Mengenali kebutuhan-kebutuhan diri sendiri yang memerlukan orang lain dalam pemenuhannya.'
            ],
            [
                'subelemen_id' => 24,
                'fase' => 'b',
                'deskripsi' => 'Menyadari bahwa setiap orang membutuhkan orang lain dalam memenuhi kebutuhannya dan perlunya saling membantu.'
            ],
            [
                'subelemen_id' => 24,
                'fase' => 'c',
                'deskripsi' => 'Menyadari bahwa meskipun setiap orang memiliki otonominya masing-masing, setiap orang membutuhkan orang lain dalam memenuhi kebutuhannya.'
            ],

            // Koordinasi Sosial
            [
                'subelemen_id' => 25,
                'fase' => 'a',
                'deskripsi' => 'Melaksanakan aktivitas kelompok sesuai dengan kesepakatan bersama dengan bimbingan, dan saling mengingatkan adanya kesepakatan tersebut.'
            ],
            [
                'subelemen_id' => 25,
                'fase' => 'b',
                'deskripsi' => 'Menyadari bahwa dirinya memiliki peran yang berbeda dengan orang lain/temannya, serta mengetahui konsekuensi perannya terhadap ketercapaian tujuan.'
            ],
            [
                'subelemen_id' => 25,
                'fase' => 'c',
                'deskripsi' => 'Menyelaraskan tindakannya sesuai dengan perannya dan mempertimbangkan peran orang lain untuk mencapai tujuan bersama.'
            ],

            // Tanggap terhadap lingkungan Sosial
            [
                'subelemen_id' => 26,
                'fase' => 'a',
                'deskripsi' => 'Peka dan mengapresiasi orang-orang di lingkungan sekitar, kemudian melakukan tindakan sederhana untuk mengungkapkannya.'
            ],
            [
                'subelemen_id' => 26,
                'fase' => 'b',
                'deskripsi' => 'Peka dan mengapresiasi orang-orang di lingkungan sekitar, kemudian melakukan tindakan untuk menjaga keselarasan dalam berelasi dengan orang lain.'
            ],
            [
                'subelemen_id' => 26,
                'fase' => 'c',
                'deskripsi' => 'Tanggap terhadap lingkungan sosial sesuai dengan tuntutan peran sosialnya dan menjaga keselarasan dalam berelasi dengan orang lain.'
            ],

            // Persepsi sosial
            [
                'subelemen_id' => 27,
                'fase' => 'a',
                'deskripsi' => 'Mengenali berbagai reaksi orang lain di lingkungan sekitar dan penyebabnya.'
            ],
            [
                'subelemen_id' => 27,
                'fase' => 'b',
                'deskripsi' => 'Memahami berbagai alasan orang lain menampilkan respon tertentu.'
            ],
            [
                'subelemen_id' => 27,
                'fase' => 'c',
                'deskripsi' => 'Menerapkan pengetahuan mengenai berbagai reaksi orang lain dan penyebabnya dalam konteks keluarga, sekolah, serta pertemanan dengan sebaya.'
            ],

            // Berbagi
            [
                'subelemen_id' => 28,
                'fase' => 'a',
                'deskripsi' => 'Memberi dan menerima hal yang dianggap berharga dan penting kepada/dari orang-orang di lingkungan sekitar.'
            ],
            [
                'subelemen_id' => 28,
                'fase' => 'b',
                'deskripsi' => 'Memberi dan menerima hal yang dianggap penting dan berharga kepada/dari orang-orang di lingkungan sekitar baik yang dikenal maupun tidak dikenal.'
            ],
            [
                'subelemen_id' => 28,
                'fase' => 'c',
                'deskripsi' => 'Memberi dan menerima hal yang dianggap penting dan berharga kepada/dari orang-orang di lingkungan luas/masyarakat baik yang dikenal maupun tidak dikenal.'
            ],

            // Mengenali kualitas dan minat diri serta tantangan yang dihadapi
            [
                'subelemen_id' => 29,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi dan menggambarkan kemampuan, prestasi, dan ketertarikannya secara subjektif.'
            ],
            [
                'subelemen_id' => 29,
                'fase' => 'b',
                'deskripsi' => 'Mengidentifikasi kemampuan, prestasi, dan ketertarikannya serta tantangan yang dihadapi berdasarkan kejadian-kejadian yang dialaminya dalam kehidupan sehari-hari.'
            ],
            [
                'subelemen_id' => 29,
                'fase' => 'c',
                'deskripsi' => 'Menggambarkan pengaruh kualitas dirinya terhadap pelaksanaan dan hasil belajar; serta mengidentifikasi kemampuan yang ingin dikembangkan dengan mempertimbangkan tantangan yang dihadapinya dan umpan balik dari orang dewasa.'
            ],

            // Mengembangkan refleksi diri
            [
                'subelemen_id' => 30,
                'fase' => 'a',
                'deskripsi' => 'Melakukan refleksi untuk mengidentifikasi kekuatan dan kelemahan, serta prestasi dirinya.'
            ],
            [
                'subelemen_id' => 30,
                'fase' => 'b',
                'deskripsi' => 'Melakukan refleksi untuk mengidentifikasi kekuatan, kelemahan, dan prestasi dirinya, serta situasi yang dapat mendukung dan menghambat pembelajaran dan pengembangan dirinya.'
            ],
            [
                'subelemen_id' => 30,
                'fase' => 'c',
                'deskripsi' => 'Melakukan refleksi untuk mengidentifikasi faktor-faktor di dalam maupun di luar dirinya yang dapat mendukung/menghambatnya dalam belajar dan mengembangkan diri; serta mengidentifikasi cara-cara untuk mengatasi kekurangannya.'
            ],

            // Regulasi emosi
            [
                'subelemen_id' => 31,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi perbedaan emosi yang dirasakannya dan situasi-situasi yang menyebabkan-nya; serta mengekspresi-kan secara wajar.'
            ],
            [
                'subelemen_id' => 31,
                'fase' => 'b',
                'deskripsi' => 'Mengetahui adanya pengaruh orang lain, situasi, dan peristiwa yang terjadi terhadap emosi yang dirasakannya; serta berupaya untuk mengekspresikan emosi secara tepat dengan mempertimbangkan perasaan dan kebutuhan orang lain disekitarnya.'
            ],
            [
                'subelemen_id' => 31,
                'fase' => 'c',
                'deskripsi' => 'Memahami perbedaan emosi yang dirasakan dan dampaknya terhadap proses belajar dan interaksinya dengan orang lain; serta mencoba cara-cara yang sesuai untuk mengelola emosi agar dapat menunjang aktivitas belajar dan interaksinya dengan orang lain.'
            ],

            // Penetapan tujuan belajar, prestasi, dan pengembangan diri serta rencana strategis untuk mencapainya
            [
                'subelemen_id' => 32,
                'fase' => 'a',
                'deskripsi' => 'Menetapkan target belajar dan merencanakan waktu dan tindakan belajar yang akan dilakukannya.'
            ],
            [
                'subelemen_id' => 32,
                'fase' => 'b',
                'deskripsi' => 'Menjelaskan pentingnya memiliki tujuan dan berkomitmen dalam mencapainya serta mengeksplorasi langkah-langkah yang sesuai untuk mencapainya.'
            ],
            [
                'subelemen_id' => 32,
                'fase' => 'c',
                'deskripsi' => 'Menilai faktor-faktor (kekuatan dan kelemahan) yang ada pada dirinya dalam upaya mencapai tujuan belajar, prestasi, dan pengembangan dirinya serta mencoba berbagai strategi untuk mencapainya.'
            ],

            // Menunjukkan inisiatif dan bekerja secara mandiri
            [
                'subelemen_id' => 33,
                'fase' => 'a',
                'deskripsi' => 'Berinisiatif untuk mengerjakan tugas-tugas rutin secara mandiri dibawah pengawasan dan dukungan orang dewasa.'
            ],
            [
                'subelemen_id' => 33,
                'fase' => 'b',
                'deskripsi' => 'Mempertimbangkan, memilih dan mengadopsi berbagai strategi dan mengidentifikasi sumber bantuan yang diperlukan serta berinisiatif menjalankannya untuk mendapatkan hasil belajar yang diinginkan.'
            ],
            [
                'subelemen_id' => 33,
                'fase' => 'c',
                'deskripsi' => 'Memahami arti penting bekerja secara mandiri serta inisiatif untuk melakukannya dalam menunjang pembelajaran dan pengembangan dirinya.'
            ],

            // Mengembangkan pengendalian dan disiplin diri
            [
                'subelemen_id' => 34,
                'fase' => 'a',
                'deskripsi' => 'Melaksanakan kegiatan belajar di kelas dan menyelesaikan tugas-tugas dalam waktu yang telah disepakati.'
            ],
            [
                'subelemen_id' => 34,
                'fase' => 'b',
                'deskripsi' => 'Menjelaskan pentingnya mengatur diri secara mandiri dan mulai menjalankan kegiatan dan tugas yang telah sepakati secara mandiri.'
            ],
            [
                'subelemen_id' => 34,
                'fase' => 'c',
                'deskripsi' => 'Mengidentifikasi faktor-faktor yang dapat mempengaruhi kemampuan dalam mengelola diri dalam pelaksanaan aktivitas belajar dan pengembangan dirinya.'
            ],

            // Percaya diri, tangguh (resilient), dan adaptif
            [
                'subelemen_id' => 35,
                'fase' => 'a',
                'deskripsi' => 'Berani mencoba dan adaptif menghadapi situasi baru serta bertahan mengerjakan tugas-tugas yang disepakati hingga tuntas.'
            ],
            [
                'subelemen_id' => 35,
                'fase' => 'b',
                'deskripsi' => 'Tetap bertahan mengerjakan tugas ketika dihadapkan dengan tantangan dan berusaha menyesuaikan strateginya ketika upaya sebelumnya tidak berhasil.'
            ],
            [
                'subelemen_id' => 35,
                'fase' => 'c',
                'deskripsi' => 'Menyusun, menyesuaikan, dan mengujicobakan berbagai strategi dan cara kerjanya untuk membantu dirinya dalam penyelesaian tugas yang menantang.'
            ],

            // Mengajukan pertanyaan
            [
                'subelemen_id' => 36,
                'fase' => 'a',
                'deskripsi' => 'Mengajukan pertanyaan untuk menjawab keingintahuannya dan untuk mengidentifikasi suatu permasalahan mengenai dirinya dan lingkungan sekitarnya.'
            ],
            [
                'subelemen_id' => 36,
                'fase' => 'b',
                'deskripsi' => 'Mengajukan pertanyaan untuk mengidentifikasi suatu permasalahan dan mengkonfirmasi pemahaman terhadap suatu permasalahan mengenai dirinya dan lingkungan sekitarnya.'
            ],
            [
                'subelemen_id' => 36,
                'fase' => 'c',
                'deskripsi' => 'Mengajukan pertanyaan untuk membandingkan berbagai informasi dan untuk menambah pengetahuannya.'
            ],

            // Mengidentifikasi, mengklarifikasi, dan mengolah informasi dan gagasan
            [
                'subelemen_id' => 37,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi dan mengolah informasi dan gagasan.'
            ],
            [
                'subelemen_id' => 37,
                'fase' => 'b',
                'deskripsi' => 'Mengumpulkan, mengklasifikasikan, membandingkan dan memilih informasi dan gagasan dari berbagai sumber.'
            ],
            [
                'subelemen_id' => 37,
                'fase' => 'c',
                'deskripsi' => 'Mengumpulkan, mengklasifikasikan, membandingkan, dan memilih informasi dari berbagai sumber, serta memperjelas informasi dengan bimbingan orang dewasa.'
            ],

            // Menganalisis dan mengevaluasi penalaran dan prosedurnya
            [
                'subelemen_id' => 38,
                'fase' => 'a',
                'deskripsi' => 'Melakukan penalaran konkrit dan memberikan alasan dalam menyelesaikan masalah dan mengambil keputusan.'
            ],
            [
                'subelemen_id' => 38,
                'fase' => 'b',
                'deskripsi' => 'Menjelaskan alasan yang relevan dalam penyelesaian masalah dan pengambilan keputusan.'
            ],
            [
                'subelemen_id' => 38,
                'fase' => 'c',
                'deskripsi' => 'Menjelaskan alasan yang relevan dan akurat dalam penyelesaian masalah dan pengambilan keputusan.'
            ],

            // Merefleksi dan mengevaluasi pemikirannya sendiri
            [
                'subelemen_id' => 39,
                'fase' => 'a',
                'deskripsi' => 'Menyampaikan apa yang sedang dipikirkan secara terperinci.'
            ],
            [
                'subelemen_id' => 39,
                'fase' => 'b',
                'deskripsi' => 'Menyampaikan apa yang sedang dipikirkan dan menjelaskan alasan dari hal yang dipikirkan.'
            ],
            [
                'subelemen_id' => 39,
                'fase' => 'c',
                'deskripsi' => 'Memberikan alasan dari hal yang dipikirkan, serta menyadari kemungkinan adanya bias pada pemikirannya sendiri.'
            ],

            // Menghasilkan gagasan yang orisinal
            [
                'subelemen_id' => 40,
                'fase' => 'a',
                'deskripsi' => 'Menggabungkan beberapa gagasan menjadi ide atau gagasan imajinatif yang bermakna untuk mengekspresikan pikiran dan/atau perasaannya.'
            ],
            [
                'subelemen_id' => 40,
                'fase' => 'b',
                'deskripsi' => 'Memunculkan gagasan imajinatif baru yang bermakna dari beberapa gagasan yang berbeda sebagai ekspresi pikiran dan/atau perasaannya.'
            ],
            [
                'subelemen_id' => 40,
                'fase' => 'c',
                'deskripsi' => 'Mengembangkan gagasan yang ia miliki untuk membuat kombinasi hal yang baru dan imajinatif untuk mengekspresikan pikiran dan/atau perasaannya.'
            ],

            // Menghasilkan karya dan tindakan yang orisinal
            [
                'subelemen_id' => 41,
                'fase' => 'a',
                'deskripsi' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya dalam bentuk karya dan/atau tindakan serta mengapresiasi karya dan tindakan yang dihasilkan.'
            ],
            [
                'subelemen_id' => 41,
                'fase' => 'b',
                'deskripsi' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya sesuai dengan minat dan kesukaannya dalam bentuk karya dan/atau tindakan serta mengapresiasi karya dan tindakan yang dihasilkan.'
            ],
            [
                'subelemen_id' => 41,
                'fase' => 'c',
                'deskripsi' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya sesuai dengan minat dan kesukaannya dalam bentuk karya dan/atau tindakan serta mengapresiasi dan mengkritik karya dan tindakan yang dihasilkan.'
            ],

            // Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan
            [
                'subelemen_id' => 42,
                'fase' => 'a',
                'deskripsi' => 'Mengidentifikasi gagasan-gagasan kreatif untuk menghadapi situasi dan permasalahan.'
            ],
            [
                'subelemen_id' => 42,
                'fase' => 'b',
                'deskripsi' => 'Membandingkan gagasan-gagasan kreatif untuk menghadapi situasi dan permasalahan.'
            ],
            [
                'subelemen_id' => 42,
                'fase' => 'c',
                'deskripsi' => 'Berupaya mencari solusi alternatif saat pendekatan yang diambil tidak berhasil berdasarkan identifikasi terhadap situasi.'
            ],

        ];
    }
}
