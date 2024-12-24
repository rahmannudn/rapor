<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanEkskulExportPDF extends Controller
{
    public TahunAjaran $tahunAjaran;
    public Kelas $kelas;

    public function __invoke(TahunAjaran $tahunAjaran, ?Kelas $kelas)
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->kelas = $kelas;

        $ekskulSiswa = $this->getEkskulSiswa();
        dump($ekskulSiswa);
    }

    private function getEkskulSiswa()
    {
        $kelas = $this->kelas;
        $ekskulSiswa = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaran['id'])
            ->when($kelas, function (Builder $q, $kelas) {
                $q->where('kelas_siswa.kelas_id', '=', $kelas['id']);
            })
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->leftJoin('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->leftJoin('nilai_ekskul', 'nilai_ekskul.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('ekskul', 'nilai_ekskul.ekskul_id', 'ekskul.id')
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama as nama_siswa',
                'kelas_siswa.kelas_id',
                'nilai_ekskul.ekskul_id',
                'nilai_ekskul.deskripsi',
                'ekskul.nama_ekskul',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get();

        return $this->formatStudentData($ekskulSiswa);
    }

    function formatStudentData($data)
    {
        $result = [];

        foreach ($data as $item) {
            $siswaId = $item['siswa_id'];

            if (!isset($result[$siswaId])) {
                $result[$siswaId] = [
                    'siswa_id' => $item['siswa_id'],
                    'nama_siswa' => $item['nama_siswa'],
                    'kelas_id' => $item['kelas_id'],
                    'ekskul' => []
                ];
            }

            // Only add ekskul if it exists
            if ($item['ekskul_id'] !== null) {
                $result[$siswaId]['ekskulData'][] = [
                    'ekskul_id' => $item['ekskul_id'],
                    'deskripsi' => $item['deskripsi'],
                    'nama_ekskul' => $item['nama_ekskul']
                ];
            }
        }

        // Convert to indexed array
        return array_values($result);
    }
}
