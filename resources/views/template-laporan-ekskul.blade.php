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
        <h1>Laporan Ekskul</h1>

        <div class="header-info">
            <p>Tahun Ajaran : </p>
            <p>Kelas : </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>NAMA KELAS</th>
                    <th>NILAI KELAS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>jajang</td>
                    <td>2a</td>
                    <td>Pramuka</td>
                    <td>Baik baik sajaa</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
