<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LaporanEkskulExportPDF extends Controller
{
    public TahunAjaran $tahunAjaran;
    public Kelas $kelas;

    public function __invoke(TahunAjaran $tahunAjaran, ?Kelas $kelas)
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->kelas = $kelas;

        $data = $this->getEkskulSiswa();
        $ekskulSiswa['siswaData'] = $data['siswaData'];
        $ekskulSiswa['daftarKelas'] = $data['daftarKelas'];
        $ekskulSiswa['nama_kelas'] = $this->kelas['nama'];
        $ekskulSiswa['tahun_ajaran'] = $this->tahunAjaran['tahun'] . " - " . Str::ucfirst($this->tahunAjaran['semester']);

        return view('template-laporan-ekskul', ['data' => $ekskulSiswa]);
    }

    private function getEkskulSiswa()
    {
        $query = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaran['id'])
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
            );

        $kelas = collect($this->kelas);
        if ($kelas->isNotEmpty()) {
            $query->where('kelas_siswa.kelas_id', '=', $kelas->id);
        }
        if ($kelas->isEmpty()) {
            $query->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                ->where('kelas.tahun_ajaran_id', $this->tahunAjaran['id'])
                ->addSelect('kelas.nama as nama_kelas');
        }
        $ekskulSiswa = $query->orderBy('siswa.nama', 'ASC')->get();

        return $this->formatStudentData($ekskulSiswa);
    }

    function formatStudentData($data)
    {
        $result = [];
        $kelas = collect($this->kelas);
        $daftarKelas = [];

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

            if ($kelas->isEmpty()) {
                $result[$siswaId]['nama_kelas'] = $item['nama_kelas'];

                $kelasId = $item['kelas_id'];
                if (!isset($daftarKelas[$kelasId])) {
                    $daftarKelas[$kelasId] = [
                        'kelas_id' => $kelasId,
                        'nama_kelas' => $item['nama_kelas'],
                    ];
                }
            }

            // Only add ekskul if it exists
            if ($item['ekskul_id'] !== null) {
                $result[$siswaId]['ekskulData'][] = [
                    'ekskul_id' => $item['ekskul_id'],
                    'deskripsi' => Str::ucfirst($item['deskripsi']),
                    'nama_ekskul' => Str::ucfirst($item['nama_ekskul']),
                ];
            }
        }

        // Convert to indexed array
        return ['siswaData' => array_values($result), 'daftarKelas' => array_values($daftarKelas)];
    }
}
