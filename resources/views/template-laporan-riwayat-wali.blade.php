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

        @media print {
            #printButton {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <button id="printButton" style="background: red; padding:20px; text-color:white;">Print</button>
        <h1>Laporan Riwayat Wali Kelas</h1>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">NO</th>
                    <th class="py-2 px-4 border-b">NAMA GURU</th>
                    <th class="py-2 px-4 border-b">KELAS</th>
                    <th class="py-2 px-4 border-b">TAHUN AJARAN</th>
                    <th class="py-2 px-4 border-b">SEMESTER</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($data as $tahunAjaran)
                    @php
                        $rowCount = count($tahunAjaran['data_kelas']);
                    @endphp
                    @foreach ($tahunAjaran['data_kelas'] as $kelas)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $counter++ }}</td>
                            <td class="py-2 px-4 border-b">{{ Str::title($kelas['nama_wali_kelas']) }}</td>
                            <td class="py-2 px-4 border-b">{{ $kelas['nama_kelas'] }}</td>
                            @if ($loop->index === 0)
                                <td rowspan="{{ $rowCount }}" class="py-2 px-4 border-b">{{ $tahunAjaran['tahun'] }}
                                </td>
                                <td rowspan="{{ $rowCount }}" class="py-2 px-4 border-b">
                                    {{ Str::title($tahunAjaran['semester']) }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
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
