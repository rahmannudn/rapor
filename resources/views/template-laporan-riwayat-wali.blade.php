@extends('components.laporan-layout.layout')

@section('title')
    Laporan Riwayat Wali Kelas
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA GURU</th>
                <th>KELAS</th>
                <th>TAHUN AJARAN</th>
                <th>SEMESTER</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($data['data_wali_kelas'] as $tahunAjaran)
                @php
                    $rowCount = count($tahunAjaran['data_kelas']);
                @endphp
                @foreach ($tahunAjaran['data_kelas'] as $kelas)
                    <tr>
                        <td class="text-center">{{ $counter++ }}</td>
                        <td>{{ Str::title($kelas['nama_wali_kelas']) }}</td>
                        <td class="text-center">{{ $kelas['nama_kelas'] }}</td>
                        @if ($loop->index === 0)
                            <td class="text-center" rowspan="{{ $rowCount }}">{{ $tahunAjaran['tahun'] }}
                            </td>
                            <td class="text-center" rowspan="{{ $rowCount }}">
                                {{ Str::title($tahunAjaran['semester']) }}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    @include('components.laporan-layout.footer')
@endsection
