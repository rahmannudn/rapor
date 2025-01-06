<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Sumatif</title>
    <style>
        /* A4 Print Styles */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            @page {
                margin-top: 25px;
                margin-bottom: 25px;
            }

            body {
                margin: 0;
                padding: 20px;
            }

            #printButton {
                display: none;
            }
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            margin: 0 auto;
            /* padding: 20px; */
            width: 95%;
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
            padding: 10px 15px;
            text-align: center;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .nama-siswa {
            text-align: left;
        }

        /* Set width for specific columns */
        th:nth-child(1),
        td:nth-child(1) {
            width: 5%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 20%;
        }

        th:nth-child(10),
        td:nth-child(10) {
            width: 25%;
        }
    </style>

</head>

<body>
    <div class="container">
        <button id="printButton" style="background: red; padding:20px; text-color:white;">Print</button>

        <h1>Laporan Proyek Dan Subproyek</h1>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA GURU</th>
                    <th>KELAS</th>
                    <th>TAHUN AJARAN</th>
                    <th>JUDUL PROYEK</th>
                    <th>DESKRIPSI PROYEK</th>
                    <th>DIMENSI</th>
                    <th>ELEMEN</th>
                    <th>SUBELEMEN</th>
                    <th>CAPAIAN FASE</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($data as $proyek)
                    @php $rowSpan = count($proyek['subproyek']); @endphp
                    @foreach ($proyek['subproyek'] as $index => $subproyek)
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ $rowSpan }}">{{ $no }}</td>
                                <td rowspan="{{ $rowSpan }}">{{ $proyek['nama_guru'] }}</td>
                                <td rowspan="{{ $rowSpan }}">{{ $proyek['nama_kelas'] }}</td>
                                <td rowspan="{{ $rowSpan }}">
                                    {{ $proyek['tahun'] . ' - ' . Str::ucfirst($proyek['semester']) }}
                                </td>
                                <td rowspan="{{ $rowSpan }}">{{ $proyek['judul_proyek'] }}</td>
                                <td rowspan="{{ $rowSpan }}">{{ $proyek['proyek_deskripsi'] }}</td>
                            @endif
                            <td>{{ $subproyek['dimensi_deskripsi'] }}</td>
                            <td>{{ $subproyek['elemen_deskripsi'] }}</td>
                            <td>{{ $subproyek['subelemen_deskripsi'] }}</td>
                            <td>{{ $subproyek['capaian_fase_deskripsi'] }}</td>
                        </tr>
                    @endforeach
                    @php $no++; @endphp
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
