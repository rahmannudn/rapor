<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Sumatif</title>
    <style>
        /* A4 Print Styles */
        @page {
            size: A4;
            margin: 0cm;
        }

        @media print {
            body {
                margin: 0;
                padding: 40px;
            }

            @page {
                size: landscape
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
            padding: 20px;
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
        <h1>Laporan Nilai Sumatif</h1>

        <div class="header-info">
            <p>Tahun Ajaran : _______________</p>
            <p>Kelas : _______________</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NAMA SISWA</th>
                    <th colspan="3">NILAI AKHIR</th>
                    <th class="average-column" rowspan="2">RATA-RATA <br> SEMUA MAPEL</th>
                </tr>
                <tr>
                    <th>MATEMATIKA</th>
                    <th>BAHASA INDONESIA</th>
                    <th>SENI BUDAYA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="nama-siswa"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="average-column"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="nama-siswa"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="average-column"></td>
                </tr>
                <tr class="summary-row">
                    <td colspan="2">NILAI TERTINGGI</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="average-column"></td>
                </tr>
                <tr class="summary-row">
                    <td colspan="2">NILAI TERENDAH</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="average-column"></td>
                </tr>
                <tr class="summary-row">
                    <td colspan="2">NILAI RATA-RATA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="average-column"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
