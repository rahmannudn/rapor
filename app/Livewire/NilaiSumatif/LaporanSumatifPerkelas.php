<?php

namespace App\Livewire\NilaiSumatif;

use App\Models\Kelas;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\JoinClause;

class LaporanSumatifPerkelas extends Component
{
    public $selectedKelas;
    public $tahunAjaranAktif;
    public $dataSiswa;
    public $dataKelas;

    public function mount()
    {
        // try {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->dataKelas = WaliKelas::where('wali_kelas.user_id', Auth::id())
            ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->select(
                'wali_kelas.id as wali_kelas_id',
                'kelas.id as kelas_id',
                'kelas.nama',
                'kelas.fase',
                'kelas.kelas'
            )
            ->first()
            ->toArray();
        $dataSiswa = $this->getSiswaData();
        if (count($dataSiswa) >= 1) {
            $this->dataSiswa = $dataSiswa->groupBy('id_siswa');
            dump($this->dataSiswa);
        }
        // } catch (\Throwable $th) {
        //     session()->flash('gagal', 'terjadi suatu kesalahan');
        //     return redirect()->route('dashboard');
        // }
    }

    public function render()
    {
        return view('livewire.nilai-sumatif.laporan-sumatif-perkelas');
    }

    public function getSiswaData()
    {
        $kelasId = $this->dataKelas['kelas_id'];
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
            ->leftJoin('nilai_sumatif', function ($join) {
                $join->on('kelas_siswa.id', '=', 'nilai_sumatif.kelas_siswa_id')
                    ->on('detail_guru_mapel.id', '=', 'nilai_sumatif.detail_guru_mapel_id');
            })
            ->leftJoin('nilai_sumatif_akhir', function ($join) {
                $join->on('kelas_siswa.id', '=', 'nilai_sumatif_akhir.kelas_siswa_id')
                    ->on('detail_guru_mapel.id', '=', 'nilai_sumatif_akhir.detail_guru_mapel_id');
            })
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
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
        return $data->groupBy('id_siswa')->map(function ($items, $idSiswa) {
            $firstItem = $items->first();
            return [
                'id_siswa' => $idSiswa,
                'nama_siswa' => $firstItem->nama_siswa,
                'mapel' => $items->map(function ($item) {
                    return [
                        'nama_mapel' => $item->nama_mapel,
                        'nilai' => $item->nilai,
                        'nilai_tes' => $item->nilai_tes,
                        'nilai_nontes' => $item->nilai_nontes,
                    ];
                })->toArray(),
            ];
        });
    }
}
