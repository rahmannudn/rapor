<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Sumatif</title>
    <style>
        /* A4 Print Styles */
        @page {
            size: A4;
            margin: 0;
            margin-top: 20px;
            padding-top: 20px;
            /* Jarak atas di setiap halaman */
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        @media print {
            body {
                /* padding: 40px; */
            }

            .container {
                /* padding: 1.5cm; */
            }

            thead {
                display: table-header-group;
            }

            /* Reset margin for repeated headers */
            thead::after {
                margin-top: 0 !important;
            }

            /* Control page breaks */
            tr {
                page-break-inside: avoid;
            }

            /* Adjust spacing for subsequent pages */
            .table-wrapper {
                margin-top: 0;
            }

            /* Remove extra space after table on page breaks */
            table {
                margin-bottom: 0;
            }
        }

        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .table-wrapper {
            /* margin-top: 20px; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Hindari putusnya baris di tengah */
        tr {
            page-break-inside: avoid;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 40px;
        }

        h1 {
            font-size: 23px;
            text-align: center;
            margin-bottom: 30px;
            margin-top: 0;
        }

        .header-info {
            margin-bottom: 20px;
        }

        .header-info p {
            margin: 5px 0;
        }

        .text-center {
            text-align: center;
        }

        thead th {
            background-color: #f2f2f2;
            padding: 12px 8px;
            /* Jarak dalam heading */
        }

        thead {
            margin-bottom: 10px;
            /* Tambahkan jarak di bawah heading */
        }

        /* Print button styles */
        #printButton {
            background-color: #ff0000;
            color: white;
            padding: 20px;
            border: none;
            cursor: pointer;
            /* margin-bottom: 20px; */
        }

        @media print {
            #printButton {
                display: none;
            }
        }
    </style>
</head>

@php
    $totalKelas = count($data['daftarKelas']);
@endphp

<body>
    <div class="container">
        <button id="printButton">Print</button>
        @include('components.laporan-layout.header')
        <h1>Laporan Nilai Ekskul</h1>

        <div class="header-info">
            <p>Tahun Ajaran : {{ $data['tahun_ajaran'] }}</p>
            @if ($totalKelas === 1)
                <p>Kelas : {{ $data['nama_kelas'] }}</p>
            @endif
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA SISWA</th>
                        @if ($totalKelas > 1)
                            <th>Kelas</th>
                        @endif
                        <th>NAMA EKSKUL</th>
                        <th>DESKRIPSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['siswaData'] as $index => $item)
                        @php
                            $ekskulData = $item['ekskulData'] ?? [];
                            $rowCount = max(count($ekskulData), 1);
                        @endphp
                        @for ($i = 0; $i < $rowCount; $i++)
                            <tr>
                                @if ($i === 0)
                                    <td class="text-center" rowspan="{{ $rowCount }}">{{ $index + 1 }}</td>
                                    <td rowspan="{{ $rowCount }}">{{ $item['nama_siswa'] }}</td>
                                    @if ($totalKelas > 1)
                                        <td rowspan="{{ $rowCount }}">{{ $item['nama_kelas'] }}</td>
                                    @endif
                                @endif
                                @if (isset($ekskulData[$i]))
                                    <td>{{ $ekskulData[$i]['nama_ekskul'] }}</td>
                                    <td>{{ $ekskulData[$i]['deskripsi'] }}</td>
                                @else
                                    <td>-</td>
                                    <td>-</td>
                                @endif
                            </tr>
                        @endfor
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("printButton").onclick = function() {
            window.print();
        }
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
