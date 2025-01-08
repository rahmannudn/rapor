@extends('components.laporan-layout.layout')

@section('css')
    .info {
    margin-bottom: 20px;
    }

    .info-item {
    margin-bottom: 5px;
    }

    .nama-siswa {
    text-align: left;
    }

    .summary-row {
    font-weight: bold;
    background-color: #f2f2f2;
    }
@endsection

@section('title')
    NILAI AKHIR ASESMEN SUMATIF {{ $result['nama_mapel'] }}
@endsection

@section('content')
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
@endsection
