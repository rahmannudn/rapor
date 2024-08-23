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
            width: 100%;
            min-height: 297mm;
            margin: auto;
            background: white;
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
                <td class="value">: {{ $result['nama_sekolah'] }}</td>
                <td class="right-label">Kelas</td>
                <td class="right-value">: {{ $result['nama_kelas'] }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Sekolah</td>
                <td class="value">: {{ $result['alamat_sekolah'] }}</td>
                <td class="right-label">Fase</td>
                <td class="right-value">: {{ Str::ucfirst($result['fase']) }}</td>
            </tr>
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="value">: {{ $result['nama_siswa'] }}</td>
                <td class="right-label">TA</td>
                <td class="right-value">: {{ $result['tahun_ajaran'] }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="value">: {{ $result['nisn'] }}</td>
                <td class="right-label"></td>
                <td class="right-value"></td>
            </tr>
        </table>

        @foreach ($result['proyek'] as $proyek)
            <div class="project-box">
                <p class="project-title">Proyek {{ $loop->index + 1 }} : {{ $proyek['judul_proyek'] }}</p>
                <p class="project-content">
                    {{ $proyek['proyek_deskripsi'] }}
                </p>
            </div>
        @endforeach

        {{-- <div class="project-box">
            <p class="project-title"></p>
            <p class="project-content">
            </p>
        </div> --}}
    </div>

    <!-- Halaman 2 -->
    @foreach ($result['proyek'] as $proyek)
        <div class="page-break"></div>
        <div class="container">
            <table class="project-detail">
                <tr>
                    <th rowspan="2" class="description-cell">{{ $proyek['judul_proyek'] }}</th>
                    <th colspan="4">Penilaian</th>
                </tr>
                <tr>
                    <th>BB</th>
                    <th>MB</th>
                    <th>BSH</th>
                    <th>SB</th>
                </tr>
                @foreach ($proyek['subproyek'] as $sub)
                    <tr>
                        <td class="description-cell">
                            <strong>{{ $sub['dimensi_deskripsi'] }}</strong><br>{{ $sub['subelemen_deskripsi'] }} -
                            {{ $sub['capaian_fase_deskripsi'] }}
                        </td>
                        <td>
                            @if ($sub['nilai'] == 'bb')
                                v
                            @endif
                        </td>
                        <td>
                            @if ($sub['nilai'] == 'mb')
                                v
                            @endif
                        </td>
                        <td>
                            @if ($sub['nilai'] == 'bsh')
                                v
                            @endif
                        </td>
                        <td>
                            @if ($sub['nilai'] == 'sb')
                                v
                            @endif
                        </td>
                    </tr>
                @endforeach

                {{-- <tr>
                    <td class="description-cell">Kreatif<br>Menghasilkan karya dan tindakan yang orisinal -
                        Mengeksplorasi
                        dan mengekspresikan pikiran dan/atau perasaannya sesuai dengan minat dan kesukaannya dalam
                        bentuk
                        karya dan/atau tindakan nyata yang produktif.</td>
                    <td></td>
                    <td>&#10004;</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai
                        dengan
                        harapan dan tujuan kelompok.</td>
                    <td></td>
                    <td></td>
                    <td>&#10004;</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai
                        dengan
                        harapan dan tujuan kelompok.</td>
                    <td></td>
                    <td></td>
                    <td>&#10004;</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="description-cell">Bergotong-Royong<br>Kerja sama - Menampilkan tindakan yang sesuai
                        dengan
                        harapan dan tujuan kelompok.</td>
                    <td></td>
                    <td></td>
                    <td>&#10004;</td>
                    <td></td>
                </tr> --}}
            </table>

            <div class="notes">
                <p>Catatan Proses</p>
                <textarea>{{ $proyek['catatan'] }}</textarea>
            </div>
        </div>
    @endforeach

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
