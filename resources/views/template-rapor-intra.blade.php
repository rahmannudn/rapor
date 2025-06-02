<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Intra - {{ $results['nisn'] }}</title>
    <style>
        @page {
            size: A4;
            margin: 20px 0;
        }

        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .student-info {
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .student-info div {
            display: contents;
        }

        .student-info label {
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .attendance-table {
            width: 300px;
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

        .text-vertical {
            text-align: center;
            vertical-align: middle;
        }

        @media print {
            #printButton {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button id="printButton" style="background: red; padding:20px; text-color:white;">Print</button>

    <div class="header">
        <b>
            <h2>LAPORAN HASIL BELAJAR<br>(RAPOR)</h2>
        </b>
    </div>

    <div class="student-info">
        <label>Nama Peserta Didik</label>
        <div>: {{ $results['nama_siswa'] }}</div>
        <label>Kelas</label>
        <div>: {{ $results['tahun_ajaran']['nama_kelas'] }} </div>

        <label>NISN</label>
        <div>: {{ $results['nisn'] }}</div>
        <label>Fase</label>
        <div>: {{ Str::upper($results['tahun_ajaran']['fase']) }}</div>

        <label>Sekolah</label>
        <div>: {{ $results['sekolah']['nama_sekolah'] }}</div>
        <label>Semester</label>
        <div>: {{ Str::ucfirst($results['tahun_ajaran']['semester']) }}</div>

        <label>Alamat</label>
        <div>: {{ $results['sekolah']['alamat_sekolah'] }}</div>
        <label>Tahun Pelajaran</label>
        <div>: {{ $results['tahun_ajaran']['tahun'] }}</div>
    </div>

    <table>
        <thead>
            <tr class="text-vertical">
                <th class="text-vertical">No</th>
                <th class="text-vertical">Muatan Pelajaran</th>
                <th class="text-vertical">Nilai Akhir</th>
                <th class="text-vertical">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results['nilai_mapel'] as $mapel)
                <tr>
                    <td rowspan="2" class="text-vertical">{{ $loop->index + 1 }}</td>
                    <td rowspan="2" style="vertical-align:middle">{{ $mapel['nama_mapel'] }}</td>
                    <td rowspan="2" class="text-vertical">{{ $mapel['rata_nilai'] }}
                    </td>
                    <td>{{ $mapel['deskripsi_tertinggi'] }}</td>
                </tr>
                <tr>

                    <td>{{ $mapel['deskripsi_terendah'] }}</td>
                </tr>
            @endforeach

            <!-- Add other subjects similarly -->
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="text-vertical">No</th>
                <th class="text-vertical">Ekstrakurikuler</th>
                <th class="text-vertical">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results['ekskul'] as $ekskul)
                <tr>
                    <td class="text-vertical">{{ $loop->index + 1 }}</td>
                    <td>{{ $ekskul['nama_ekskul'] }}</td>
                    <td>{{ $ekskul['deskripsi'] }}</td>
                </tr>
            @endforeach

            <!-- Add other rows -->
        </tbody>
    </table>

    <table class="attendance-table">
        <thead>
            <tr>
                <th colspan="3">Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sakit</td>
                <td>{{ $results['absensi']['sakit'] }}</td>
                <td>hari</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td>{{ $results['absensi']['izin'] }}</td>
                <td>hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan</td>
                <td>{{ $results['absensi']['alfa'] }}</td>
                <td>hari</td>
            </tr>
            <tr>
                <td>Presentase Kehadiran</td>
                <td>{{ $results['absensi']['presentase_kehadiran'] }}</td>
                <td>%</td>
            </tr>
        </tbody>
    </table>

    {{-- <div class="signatures">
        <div class="signature-box">
            <p>Orang Tua,</p>
            <div class="margin-top signature-line"></div>
        </div>
        <div class="signature-box">
            <p>Banjarmasin, {{ $results['kepsek']['tgl_rapor'] }}<br>Wali Kelas</p>
            <div class="margin-top"></div>
            <p>{{ Str::title($results['tahun_ajaran']['nama_wali']) }}<br>NIP.
                {{ $results['tahun_ajaran']['nip_wali'] ?? '' }}
            </p>
        </div>
    </div>

    <div class="signature-box" style="text-align: center; margin-top: 20px;">
        <p>Mengetahui,<br>Kepala Sekolah</p>
        <div class="margin-top"></div>
        <p>{{ Str::title($results['kepsek']['nama_kepsek']) }}<br>NIP. {{ $results['kepsek']['nip_kepsek'] ?? '' }}
        </p>
    </div> --}}

    <div class="signatures">
        <div class="signature-box">
            <p style="margin: 0 5px;">Mengetahui,</p>
            <p style="margin-bottom: 118px; margin-top:5px">Orang Tua</p>
            <span class="signature-line"></span>
        </div>
        <div class="signature-box">
            <p style="margin: 0 5px;">Banjarmasin, {{ $results['kepsek']['tgl_rapor'] }}</p>
            <p style="margin: 0 5px;">Wali Kelas </p>
            <p class="signature-name">{{ Str::title($results['tahun_ajaran']['nama_wali']) }}</p>
            <span class="signature-line"></span>
            <p class="signature-nip">NIP. {{ $results['tahun_ajaran']['nip_wali'] }}</p>
        </div>
        <div class="signature-box">
            <p style="margin: 0 5px;">Mengetahui,</p>
            <p style="margin: 0 5px;">Kepala Sekolah</p>
            <p class="signature-name">{{ Str::title($results['kepsek']['nama_kepsek']) }}</p>
            <span class="signature-line"></span>
            <p class="signature-nip">NIP. {{ $results['kepsek']['nip_kepsek'] ?? '' }}</p>
        </div>
    </div>

    <script>
        document.getElementById("printButton").onclick = function() {
            window.print();
        }
        window.onload = function() {
            // Tampilkan window print setelah halaman selesai dimuat
            window.print();
        };
    </script>
</body>

</html>
