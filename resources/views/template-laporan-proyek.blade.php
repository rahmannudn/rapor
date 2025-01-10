@extends('components.laporan-layout.layout')

@section('css')
    /* A4 Print Styles */
    @page {
    size: A4 landscape;
    margin: 0;
    }

    table{
    max-width:100%;
    }

    thead tr th{
    vertical-align: baseline;
    text-align:center;
    }

    tr {
    page-break-inside: auto;
    }

    th,
    td {
    border: 1px solid black;
    text-align: center;
    vertical-align: top;
    }

    {{-- /* Set width for specific columns */
    th:nth-child(1),
    td:nth-child(1) {
    width: 5%;
    }

    th:nth-child(2),
    td:nth-child(2) {
    width: 15%;
    } --}}

    {{-- th:nth-child(5),
    td:nth-child(5) {
    width: 20%;
    } --}}

    {{-- th:nth-child(10),
    td:nth-child(10) {
    width: 20%;
    } --}}
@endsection

@section('title')
    Laporan Proyek Dan Subproyek
@endsection

@section('content')
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
            @foreach ($data['data_proyek'] as $proyek)
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

    @include('components.laporan-layout.footer')
@endsection
