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

@php
    $totalKelas = count($data['daftarKelas']);
@endphp

@section('title')
    Laporan Ekskul
@endsection
@section('content')
    <div class="header-info">
        <p>Tahun Ajaran : {{ $data['tahun_ajaran'] }}</p>
        @if ($totalKelas > 1)
            <p>Kelas : {{ $data['nama_kelas'] }}</p>
        @endif
    </div>

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

    @include('components.laporan-layout.footer')
@endsection
