<style>
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
@extends('components.laporan-layout.layout')

@section('title')
    Laporan Riwayat Guru Mapel
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA GURU</th>
                <th>TAHUN</th>
                <th>SEMESTER</th>
                <th>KELAS</th>
                <th>MAPEL</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($data['guru_mapel'] as $tahunAjaran)
                @foreach ($tahunAjaran['guru_mapel'] as $guruMapel)
                    <?php
                    // Hitung rowspan guru berdasarkan jumlah mapel
                    $rowSpanGuru = 0;
                    foreach ($guruMapel['detail_guru_mapel'] as $kelas) {
                        $rowSpanGuru += count($kelas['data_mapel']);
                    }
                    $firstGuruRow = true;
                    ?>

                    @foreach ($guruMapel['detail_guru_mapel'] as $kelas)
                        <?php $firstKelasRow = true; ?>

                        @foreach ($kelas['data_mapel'] as $mapel)
                            <tr>
                                @if ($firstGuruRow)
                                    <td style="text-align: center" rowspan="{{ $rowSpanGuru }}">{{ $no++ }}</td>
                                    <td rowspan="{{ $rowSpanGuru }}">{{ Str::title($guruMapel['nama_guru']) }}</td>
                                    <td rowspan="{{ $rowSpanGuru }}">{{ $tahunAjaran['tahun'] }}</td>
                                    <td rowspan="{{ $rowSpanGuru }}">{{ ucfirst($tahunAjaran['semester']) }}</td>
                                    <?php $firstGuruRow = false; ?>
                                @endif

                                @if ($firstKelasRow)
                                    <td rowspan="{{ count($kelas['data_mapel']) }}">{{ $kelas['nama_kelas'] }}</td>
                                    <?php $firstKelasRow = false; ?>
                                @endif

                                <td>{{ $mapel['nama_mapel'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>

    @include('components.laporan-layout.footer')
@endsection
