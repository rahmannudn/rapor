@extends('components.laporan-layout.layout')
@section('css')
    /* A4 Print Styles */
    @page {
    size: A4;
    }

    .table-wrapper {
    /* margin-top: 20px; */
    }

    .header-info {
    margin-bottom: 20px;
    }

    .header-info p {
    margin: 5px 0;
    }
@endsection
@section('title')
    Laporan Absensi
@endsection
@section('content')
    <div class="header-info">
        <p>Tahun Ajaran : {{ $data['tahun_ajaran'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA SISWA</th>
                <th>NAMA KELAS</th>
                <th>BULAN</th>
                <th>SAKIT</th>
                <th>IZIN</th>
                <th>ALFA</th>
                <th>JUMLAH KEHADIRAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['absensi'] as $index => $item)
                @php
                    $bulanan = $item['kehadiran_bulanan'] ?? [];
                    $rowCount = max(count($bulanan), 1);
                @endphp
                @for ($i = 0; $i < $rowCount; $i++)
                    <tr>
                        @if ($i === 0)
                            <td class="text-center" rowspan="{{ $rowCount }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ $rowCount }}">{{ $item['nama_siswa'] }}</td>
                            <td rowspan="{{ $rowCount }}">{{ $item['nama_kelas'] }}</td>
                        @endif
                        @if (isset($bulanan[$i]))
                            <td>{{ $bulanan[$i]['bulan'] }}</td>
                            <td>{{ $bulanan[$i]['sakit'] }}</td>
                            <td>{{ $bulanan[$i]['izin'] }}</td>
                            <td>{{ $bulanan[$i]['alfa'] }}</td>
                            <td>{{ $bulanan[$i]['jumlah_kehadiran'] }}</td>
                        @else
                            <td>-</td>
                            <td>-</td>
                        @endif
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>

    @include('components.laporan-layout.footer')
@endsection
