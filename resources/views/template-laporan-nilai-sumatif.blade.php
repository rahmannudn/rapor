<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nilai Akhir {{ $result['nama_mapel'] }}</title>
    <style>
        /* Reset default margins and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* A4 print styles */
        @page {
            size: A4;
            margin: 0;
            padding: 40px;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 210mm;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .nama-siswa {
            text-align: left;
        }

        .summary-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        /* Print-specific styles */
        @media print {
            .no-print {
                display: none;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
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
    <h1>NILAI AKHIR ASESMEN SUMATIF {{ $result['nama_mapel'] }}</h1>

    <div class="info">
        <div class="info-item">TAHUN AJARAN : {{ $result['tahun'] }}/{{ Str::upper($result['semester']) }}</div>
        <div class="info-item">KELAS : {{ Str::upper($result['nama_kelas']) }}</div>
        <div class="info-item">NAMA GURU : {{ Str::upper($result['nama_guru']) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA SISWA</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <!-- Empty rows for student data -->
            @foreach ($result['siswa'] as $siswa)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td class="nama-siswa">{{ $siswa['nama_siswa'] }}</td>
                    <td>{{ $siswa['rata_nilai'] }}</td>
                </tr>
            @endforeach
            <!-- Add more rows as needed -->
        </tbody>
        <tfoot>
            <tr class="summary-row">
                <td colspan="2">NILAI RATA-RATA</td>
                <td>{{ $result['rata_nilai_permapel'] }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">NILAI TERTINGGI</td>
                <td>{{ $result['nilai_tertinggi'] }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">NILAI TERENDAH</td>
                <td>{{ $result['nilai_terendah'] }}</td>
            </tr>
        </tfoot>
    </table>
</body>

<script>
    document.getElementById("printButton").onclick = function() {
        window.print();
    }
    window.onload = function() {
        // Tampilkan window print setelah halaman selesai dimuat
        window.print();
    };
</script>

</html>
