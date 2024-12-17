<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NilaiSumatifPerkelasPDFController extends Controller
{
    public $kelasData;

    public function printNilai(Request $request, $kelas)
    {
        $kelasId = $kelas;
        $this->kelasData = Kelas::where('kelas.id', $kelasId)
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas.tahun_ajaran_id')
            ->select('kelas.nama as nama_kelas', 'tahun_ajaran.tahun', 'tahun_ajaran.semester')
            ->first()->toArray();
        if (!$this->kelasData)
            return redirect()->route('laporan_sumatif_kelas')->with('gagal', 'data tidak ditemukan');

        $dataSiswa = $request->session()->get('dataSiswa');

        return $this->generateReport($dataSiswa);
    }

    public function generateReport($data)
    {
        try {
            $students = collect($data);

            // Get unique subject names
            $subjects = $students->flatMap(function ($student) {
                return collect($student['mapel'])->pluck('nama_mapel');
            })->unique()->values()->all();

            // Process student data
            $processedStudents = $students->map(function ($student) use ($subjects) {
                $mapel = collect($student['mapel'])->keyBy('nama_mapel');
                $subjectScores = collect($subjects)->map(function ($subject) use ($mapel) {
                    return floor($mapel->get($subject, ['rata_nilai' => 0])['rata_nilai']);
                });

                return [
                    'nama_siswa' => $student['nama_siswa'],
                    'nilai' => $subjectScores,
                    'rata_rata' => round($subjectScores->avg(), 2),
                ];
            });

            // Calculate summary data
            $summary = [
                'tertinggi' => $this->calculateSummary($processedStudents, $subjects, 'max'),
                'terendah' => $this->calculateSummary($processedStudents, $subjects, 'min'),
                'rata_rata' => $this->calculateSummary($processedStudents, $subjects, 'avg'),
            ];
            $summary['rata_rata_total'] = floor(collect($summary['rata_rata'])->avg());
            $kelasData = $this->kelasData;

            return view('template-nilai-sumatif-perkelas', [
                'processedStudents' => $processedStudents,
                'subjects' => $subjects,
                'summary' => $summary,
                'kelasData' => $kelasData,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error in generateReport: ' . $e->getMessage());
            return redirect()->route('laporan_sumatif_kelas')->with('gagal', 'cetak gagal');
        }
    }

    private function calculateSummary($processedStudents, $subjects, $operation)
    {
        return  collect($subjects)->mapWithKeys(function ($subject, $index) use ($processedStudents, $operation) {
            $values = $processedStudents->map(function ($student) use ($index) {
                return $student['nilai'][$index] ?? 0;
            });

            $result = 0;
            if ($operation === 'max') {
                $result = $values->max();
            } elseif ($operation === 'min') {
                $result = $values->min();
            } elseif ($operation === 'avg') {
                $result = round($values->avg(), 2);
            }

            return [$subject => $operation === 'avg' ? $result : $result];
        });
    }
}
