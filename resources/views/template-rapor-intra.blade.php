<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Intra - {{ $results['nisn'] }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 10px;
        }

        .signature-box {
            text-align: center;
        }

        .margin-top {
            margin-top: 60px;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            display: inline-block;
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
        <h2>LAPORAN HASIL BELAJAR<br>(RAPOR)</h2>
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
            <tr style="text-align: center; vertical-align: middle">
                <th style="text-align: center; vertical-align: middle">No</th>
                <th style="text-align: center; vertical-align: middle">Muatan Pelajaran</th>
                <th style="text-align: center; vertical-align: middle">Nilai Akhir</th>
                <th style="text-align: center; vertical-align: middle">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results['nilai_mapel'] as $mapel)
                <tr>
                    <td rowspan="2" style="text-align: center; vertical-align:middle">{{ $loop->index + 1 }}</td>
                    <td rowspan="2" style="vertical-align:middle">{{ $mapel['nama_mapel'] }}</td>
                    <td rowspan="2" style="text-align: center; vertical-align:middle">{{ $mapel['rata_nilai'] }}
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
                <th>No</th>
                <th>Ekstrakurikuler</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results['ekskul'] as $ekskul)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
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
                <th colspan="3">Ketidakhadiran</th>
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
        </tbody>
    </table>

    <div class="signatures">
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
