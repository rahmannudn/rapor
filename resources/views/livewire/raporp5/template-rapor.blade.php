<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Proyek Penguatan Profil Pelajar Pancasila</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            background: white;
            padding: 20mm 15mm;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        h2,
        h3 {
            text-align: center;
            margin: 5px 0;
        }

        #info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: left;
            border: 0;
        }

        #info-table td {
            padding: 5px;
            vertical-align: top;
            text-align: left;
        }

        #info-table .label {
            width: 20%;
        }

        #info-table .value {
            width: 40%;
        }

        #info-table .right-label {
            width: 15%;
            text-align: left;
        }

        #info-table .right-value {
            width: 35%;
        }

        .project-box {
            margin-bottom: 20px;
        }

        .project-title {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .project-content {
            padding: 10px;
            border: 1px solid #000;
            height: 150px;
        }

        .empty-box {
            height: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .project-detail,
        .project-detail th,
        .project-detail td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .description-cell {
            text-align: left;
        }

        .checkmark {
            font-size: 18px;
        }

        .notes {
            margin-top: 20px;
        }

        .notes textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #000;
        }

        .table-container {
            width: 100%;
            margin-bottom: 40px;
        }

        .signatures {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }

        .signature-box {
            width: 33%;
            display: inline-block;
            vertical-align: top;
            margin: 0 20px;
            text-align: center;
        }


        .signature-line {
            margin-top: 5px;
            display: block;
            border-top: 1px solid black;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-name {
            font-weight: bold;
            margin-top: 100px;
            margin-bottom: 5px;
            /* Pindahkan ke atas garis */
        }

        .signature-nip {
            margin-top: 2px;
        }

        .page-break {
            page-break-before: always;
        }

        .kemampuan-siswa {
            margin-top: 20px;
            border: 1px solid black;
        }

        .kemampuan-siswa * {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <!-- Halaman 1 -->
    <div class="container">
        <h2>RAPOR PROYEK PENGUATAN</h2>
        <h2>PROFIL PELAJAR PANCASILA</h2>

        <table id="info-table">
            <tr>
                <td class="label">Nama Sekolah</td>
                <td class="value">: SD NEGERI KUIN UTARA 7</td>
                <td class="right-label">Kelas</td>
                <td class="right-value">: IV</td>
            </tr>
            <tr>
                <td class="label">Alamat Sekolah</td>
                <td class="value">: Gg. Al Mizan Jl. Kuin Utara</td>
                <td class="right-label">Fase</td>
                <td class="right-value">: B</td>
            </tr>
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="value">: Siti Sultonah</td>
                <td class="right-label">TA</td>
                <td class="right-value">: 2023/2024</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="value">:</td>
                <td class="right-label"></td>
                <td class="right-value"></td>
            </tr>
        </table>

        <div class="project-box">
            <p class="project-title">Proyek 1 : Dari Sampah Plastik Menjadi Karya Menarik</p>
            <p class="project-content">
                Pemanfaatan sampah plastik untuk pembuatan ecobrick adalah pendekatan kreatif dan berkelanjutan dalam
                menghadapi masalah limbah plastik yang terus meningkat.
                Dengan mengumpulkan, mencacah, dan mengisi botol plastik bekas dengan plastik yang padat, ecobrick
                menjadi bata plastik yang solid. Proses ini membantu mengurangi jumlah sampah plastik yang berakhir di
                lingkungan dan memberikan solusi yang ramah lingkungan dengan mengubah sampah plastik menjadi sumber
                daya yang bernilai.
            </p>
        </div>

        <div class="project-box">
            <p class="project-title">Proyek 2 : Daur Ulang Sampah Organik Menjadi Kompos</p>
            <p class="project-content">
                Daur ulang sampah organik menjadi kompos adalah suatu proses yang mengubah sisa-sisa organik seperti
                sisa makanan, daun kering, dan bahan organik lainnya menjadi bahan kompos yang bernilai tinggi.
                Kompos yang dihasilkan dari daur ulang sampah organik ini merupakan pupuk alami yang sangat baik untuk
                meningkatkan kesuburan tanah, meningkatkan kemampuan tanah dalam menahan air, serta mengurangi
                ketergantungan pada pupuk kimia yang berbahaya bagi lingkungan.
            </p>
        </div>

        <div class="project-box">
            <p class="project-title"></p>
            <p class="project-content">
            </p>
        </div>
    </div>

    <!-- Halaman 2 -->
    <div class="page-break"></div>
    <div class="container">
        <table class="project-detail">
            <tr>
                <th rowspan="2" class="description-cell">Dari Sampah Plastik Menjadi Karya Menarik</th>
                <th colspan="4">Penilaian</th>
            </tr>
            <tr>
                <th>BB</th>
                <th>MB</th>
                <th>BSH</th>
                <th>SB</th>
            </tr>
            <tr>
                <td class="description-cell">Bergotong-Royong<br>Persepsi sosial - Memahami berbagai alasan orang lain
                    menampilkan respon tertentu</td>
                <td></td>
                <td>&#10004;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="description-cell">Kreatif<br>Menghasilkan karya dan tindakan yang orisinal - Mengeksplorasi
                    dan mengekspresikan pikiran dan/atau perasaannya sesuai dengan minat dan kesukaannya dalam bentuk
                    karya dan/atau tindakan nyata yang produktif.</td>
                <td></td>
                <td>&#10004;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai dengan
                    harapan dan tujuan kelompok.</td>
                <td></td>
                <td></td>
                <td>&#10004;</td>
                <td></td>
            </tr>
            <tr>
                <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai dengan
                    harapan dan tujuan kelompok.</td>
                <td></td>
                <td></td>
                <td>&#10004;</td>
                <td></td>
            </tr>
            <tr>
                <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai dengan
                    harapan dan tujuan kelompok.</td>
                <td></td>
                <td></td>
                <td>&#10004;</td>
                <td></td>
            </tr>
        </table>

        <div class="notes">
            <p>Catatan Proses</p>
            <textarea></textarea>
        </div>
    </div>

    <!-- Halaman 3 -->
    <div class="page-break"></div>
    <div class="container">
        <h2>KETERANGAN TINGKAT PENCAPAIAN SISWA</h2>
        <div class="table-container">
            <table class="kemampuan-siswa">
                <tr>
                    <th>BB</th>
                    <th>MB</th>
                    <th>BSH</th>
                    <th>SB</th>
                </tr>
                <tr>
                    <td>Belum Berkembang</td>
                    <td>Mulai Berkembang</td>
                    <td>Berkembang sesuai harapan</td>
                    <td>Sangat Berkembang</td>
                </tr>
                <tr>
                    <td class="description-cell">Siswa masih membutuhkan bimbingan dalam mengembangkan kemampuan</td>
                    <td class="description-cell">Siswa mulai mengembangkan kemampuan namun masih belum ajek</td>
                    <td class="description-cell">Siswa telah mengembangkan kemampuan hingga berada dalam tahap ajek</td>
                    <td class="description-cell">Siswa mengembangkan kemampuannya melampaui harapan</td>
                </tr>
            </table>
        </div>
        <div class="signatures">
            <div class="signature-box">
                <p style="margin: 0 5px;">Mengetahui,</p>
                <p style="margin-bottom: 135px; margin-top:5px">Orang Tua</p>
                <span class="signature-line"></span>
            </div>
            <div class="signature-box">
                <p style="margin: 0 5px;">Banjarmasin, 17 Desember 2023</p>
                <p style="margin: 0 5px;">Wali Kelas IV</p>
                <p class="signature-name">Nazar Mutawali, S.Pd.</p>
                <span class="signature-line"></span>
                <p class="signature-nip">NIP. 19930401202221 1 010</p>
            </div>
            <div class="signature-box">
                <p style="margin: 0 5px;">Mengetahui,</p>
                <p style="margin: 0 5px;">Kepala Sekolah</p>
                <p class="signature-name">Sri Khusniyati, S.Pd.</p>
                <span class="signature-line"></span>
                <p class="signature-nip">NIP. 19710215 200604 2 004</p>
            </div>
        </div>
    </div>
</body>

</html>
