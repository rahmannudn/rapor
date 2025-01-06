<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Sumatif</title>
    <style>
        /* A4 Print Styles */
        @page {
            size: A4 landscape;
        }

        @media print {
            body {
                padding: 0 40px;
                margin: 0;
            }

            @page {
                size: landscape;
                margin: 0;
                margin-top: 30px;
                margin-bottom: 20px;
            }

            #printButton {
                display: none;
            }
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .container {
            max-width: 21cm;
            /* A4 width */
            margin: 0 auto;
            /* padding: 20px; */
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-info {
            margin-bottom: 20px;
        }

        .header-info p {
            margin: 5px 0;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .average-column {
            background-color: #e6e6e6;
        }
    </style>
</head>

<body>
    <div class="container">
        <button id="printButton" style="background: red; padding:20px; text-color:white;">Print</button>

        <h1>Laporan Nilai Sumatif</h1>

        <div class="header-info">
            <p>Tahun Ajaran : {{ $kelasData['tahun'] }} - {{ $kelasData['semester'] }}</p>
            <p>Kelas : {{ $kelasData['nama_kelas'] }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NAMA SISWA</th>
                    <th colspan="{{ count($subjects) + 1 }}">NILAI AKHIR</th>
                </tr>
                <tr>
                    @foreach ($subjects as $subject)
                        <th>{{ strtoupper($subject) }}</th>
                    @endforeach
                    <th class="average-column">RATA-RATA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($processedStudents as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="nama-siswa">{{ $student['nama_siswa'] }}</td>
                        @foreach ($student['nilai'] as $nilai)
                            <td>{{ $nilai }}</td>
                        @endforeach
                        <td class="average-column">{{ number_format($student['rata_rata']) }}</td>
                    </tr>
                @endforeach
                <tr class="summary-row">
                    <td colspan="2">NILAI TERTINGGI</td>
                    @foreach ($summary['tertinggi'] as $nilai)
                        <td>{{ $nilai }}</td>
                    @endforeach
                    <td class="average-column">{{ $summary['tertinggi']->max() }}</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="2">NILAI TERENDAH</td>
                    @foreach ($summary['terendah'] as $nilai)
                        <td>{{ $nilai }}</td>
                    @endforeach
                    <td class="average-column">{{ $summary['terendah']->min() }}</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="2">NILAI RATA-RATA</td>
                    @foreach ($summary['rata_rata'] as $nilai)
                        <td>{{ $nilai }}</td>
                    @endforeach
                    <td class="average-column">{{ number_format($summary['rata_rata_total'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
