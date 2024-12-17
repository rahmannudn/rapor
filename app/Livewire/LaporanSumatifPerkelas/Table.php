<?php

namespace App\Livewire\LaporanSumatifPerkelas;

use App\Models\Kelas;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\JoinClause;
use App\Exports\LaporanSumatifPerkelasExport;

class Table extends Component
{
    public $selectedKelas;
    public $tahunAjaranAktif;
    public $dataSiswa;
    public $dataKelas;
    public $daftarMapel;

    public function render()
    {
        return view('livewire.laporan-sumatif-perkelas.table');
    }

    public function mount()
    {
        // try {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->dataKelas = WaliKelas::where('wali_kelas.user_id', Auth::id())
            ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->join('tahun_ajaran', 'wali_kelas.tahun_ajaran_id', 'tahun_ajaran.id')
            ->select(
                'tahun_ajaran.semester',
                'tahun_ajaran.tahun',
                'wali_kelas.id as wali_kelas_id',
                'kelas.id as kelas_id',
                'kelas.nama as nama_kelas',
                'kelas.fase',
                'kelas.kelas'
            )
            ->first()
            ->toArray();

        if (!empty($this->dataKelas)) $this->selectedKelas = $this->dataKelas['kelas_id'];

        $this->dataSiswa = $this->getSiswaData();
        if (!empty($this->dataSiswa)) $this->daftarMapel = $this->dataSiswa[0]['mapel'];

        // } catch (\Throwable $th) {
        //     session()->flash('gagal', 'terjadi suatu kesalahan');
        //     return redirect()->route('dashboard');
        // }
    }

    public function getSiswaData()
    {
        $kelasId = $this->selectedKelas;
        $tahunAjaranId = $this->tahunAjaranAktif;

        $dataSiswa =  DB::table('kelas_siswa')
            ->join('siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->join('detail_guru_mapel', function ($join) use ($kelasId, $tahunAjaranId) {
                $join->on('kelas_siswa.kelas_id', '=', 'detail_guru_mapel.kelas_id')
                    ->where('detail_guru_mapel.kelas_id', '=', $kelasId);
            })
            ->join('guru_mapel', function ($join) use ($tahunAjaranId) {
                $join->on('detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
                    ->where('guru_mapel.tahun_ajaran_id', '=', $tahunAjaranId);
            })
            ->join('mapel', 'detail_guru_mapel.mapel_id', '=', 'mapel.id')
            ->leftJoin('lingkup_materi', function ($join) {
                $join->on('lingkup_materi.detail_guru_mapel_id', '=', 'detail_guru_mapel.id');
            })
            ->leftJoin('nilai_sumatif', function ($join) {
                $join->on('kelas_siswa.id', '=', 'nilai_sumatif.kelas_siswa_id')
                    ->on('detail_guru_mapel.id', '=', 'nilai_sumatif.detail_guru_mapel_id')
                    ->on('lingkup_materi.detail_guru_mapel_id', '=', 'nilai_sumatif.detail_guru_mapel_id');
            })
            ->leftJoin('nilai_sumatif_akhir', function ($join) {
                $join->on('kelas_siswa.id', '=', 'nilai_sumatif_akhir.kelas_siswa_id')
                    ->on('detail_guru_mapel.id', '=', 'nilai_sumatif_akhir.detail_guru_mapel_id');
            })
            ->select(
                'lingkup_materi.id as id_lingkup_materi',
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'mapel.id as id_mapel',
                'mapel.nama_mapel as nama_mapel',
                DB::raw('COALESCE(nilai_sumatif.nilai, 0) as nilai'),
                DB::raw('COALESCE(nilai_sumatif_akhir.nilai_tes, 0) as nilai_tes'),
                DB::raw('COALESCE(nilai_sumatif_akhir.nilai_nontes, 0) as nilai_nontes'),
            )
            ->where('kelas_siswa.kelas_id', $kelasId)
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranId)
            ->orderBy('siswa.nama')
            ->orderBy('mapel.nama_mapel')
            ->get();

        return $this->formatDataSiswa($dataSiswa);
    }

    public function formatDataSiswa($data)
    {
        $groupedData = $data->groupBy('id_siswa');
        $results = [];

        foreach ($groupedData as $studentId => $studentData) {
            $result = [
                'id_siswa' => $studentId,
                'nama_siswa' => $studentData->first()->nama_siswa,
                'mapel' => []
            ];

            $mapelData = $studentData->groupBy('id_mapel');

            foreach ($mapelData as $mapelId => $mapel) {
                $totalNilai = 0;
                $jumlahNilai = 0;
                $nilaiTes = 0;
                $nilaiNontes = 0;
                $processedLingkupMateri = [];

                foreach ($mapel as $item) {
                    // Cek apakah id_lingkup_materi sudah diproses sebelumnya
                    if (!in_array($item->id_lingkup_materi, $processedLingkupMateri)) {
                        $totalNilai += $item->nilai;
                        $jumlahNilai++;
                        $processedLingkupMateri[] = $item->id_lingkup_materi;
                    }

                    // Hanya ambil nilai_tes dan nilai_nontes sekali
                    if ($nilaiTes == 0 && $item->nilai_tes > 0) {
                        $nilaiTes = $item->nilai_tes;
                    }
                    if ($nilaiNontes == 0 && $item->nilai_nontes > 0) {
                        $nilaiNontes = $item->nilai_nontes;
                    }
                }

                // Tambahkan nilai_tes dan nilai_nontes jika ada
                if ($nilaiTes > 0) {
                    $totalNilai += $nilaiTes;
                    $jumlahNilai++;
                }
                if ($nilaiNontes > 0) {
                    $totalNilai += $nilaiNontes;
                    $jumlahNilai++;
                }

                $rataNilai = $jumlahNilai > 0 ? $totalNilai / $jumlahNilai : 0;

                $result['mapel'][] = [
                    'id_mapel' => $mapelId,
                    'nama_mapel' => $mapel->first()->nama_mapel,
                    'total_nilai' => $totalNilai,
                    'jumlah_nilai' => $jumlahNilai,
                    'rata_nilai' => round($rataNilai, 2),
                ];
            }

            $results[] = $result;
        }

        return $results;
    }

    public function exportExcel()
    {
        $dataSiswa = $this->dataSiswa;
        $daftarMapel = $this->daftarMapel;
        return (new LaporanSumatifPerkelasExport($dataSiswa, $daftarMapel))
            ->download('lapora_sumatif_perkelas.xlsx', Excel::XLSX);
    }

    public function exportPDF()
    {
        $dataSiswa = $this->dataSiswa;
        $daftarMapel = $this->daftarMapel;
        $kelas = $this->selectedKelas;

        // Simpan data di session
        session()->put('dataSiswa', $dataSiswa);
        session()->put('daftarMapel', $daftarMapel);

        // Dispatch event dengan detail kelas
        $this->dispatch('dataProcessed', ['kelas' => $kelas]);
    }
}
