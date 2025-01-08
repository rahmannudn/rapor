@extends('components.laporan-layout.layout')

@section('css')
    /* A4 Print Styles */
    @page {
    size: A4 landscape;
    }

    @media print {
    @page {
    size: landscape;
    margin: 0;
    margin-top: 20px;
    margin-bottom: 20px;
    }
    }

    .header-info {
    margin-bottom: 20px;
    }

    .header-info p {
    margin: 5px 0;
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
@endsection

@section('title')
    Laporan Nilai Sumatif
@endsection
@section('content')
    <div class="header-info">
        <p>Tahun Ajaran : {{ $kelasData['tahun'] }} - {{ $kelasData['semester'] }}</p>
        <p>Kelas : {{ $kelasData['nama_kelas'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA SISWA</th>
                <th colspan="{{ count($subjects) + 1 }}">NILAI AKHIR</th>
            </tr>
            <tr>
                @foreach ($subjects as $subject)
                    <th>{{ strtoupper($subject) }}</th>
                @endforeach
                <th class="average-column">RATA-RATA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($processedStudents as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="nama-siswa">{{ $student['nama_siswa'] }}</td>
                    @foreach ($student['nilai'] as $nilai)
                        <td>{{ $nilai }}</td>
                    @endforeach
                    <td class="average-column">{{ number_format($student['rata_rata']) }}</td>
                </tr>
            @endforeach
            <tr class="summary-row">
                <td colspan="2">NILAI TERTINGGI</td>
                @foreach ($summary['tertinggi'] as $nilai)
                    <td>{{ $nilai }}</td>
                @endforeach
                <td class="average-column">{{ $summary['tertinggi']->max() }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">NILAI TERENDAH</td>
                @foreach ($summary['terendah'] as $nilai)
                    <td>{{ $nilai }}</td>
                @endforeach
                <td class="average-column">{{ $summary['terendah']->min() }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">NILAI RATA-RATA</td>
                @foreach ($summary['rata_rata'] as $nilai)
                    <td>{{ $nilai }}</td>
                @endforeach
                <td class="average-column">{{ number_format($summary['rata_rata_total'], 2) }}</td>
            </tr>
        </tbody>
    </table>
@endsection
