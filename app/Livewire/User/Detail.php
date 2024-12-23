<?php

namespace App\Livewire\User;

use App\Models\GuruMapel;
use Livewire\Component;
use App\Models\User;
use App\Models\WaliKelas;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Gate;

class Detail extends Component
{
    public User $user;
    public $riwayatMapel;
    public $riwayatKelasProyek;

    public function render()
    {
        return view('livewire.user.detail');
    }

    public function mount()
    {
        if ($this->user['role'] == 'guru') {
            $this->riwayatMapel = $this->getRiwayatMapel();
            $this->riwayatKelasProyek = $this->getRiwayatKelasProyek();
            // dump($this->riwayatKelasProyek);
        }
    }

    public function getRiwayatKelasProyek()
    {
        $proyekData = WaliKelas::where('wali_kelas.user_id', $this->user['id'])
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'wali_kelas.tahun_ajaran_id')
            ->leftJoin('proyek', 'proyek.wali_kelas_id', 'wali_kelas.id')
            ->select(
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
                'proyek.id as proyek_id',
                'proyek.judul_proyek',
                'proyek.deskripsi as deskripsi_proyek',
                'users.name as nama_wali_kelas',
                'kelas.nama as nama_kelas',
                'kelas.id as kelas_id',
            )
            ->orderBy('kelas.nama')
            ->orderBy('tahun_ajaran.id')
            ->get()
            ->toArray();

        return $this->formatRiwayatKelas($proyekData);
    }

    function formatRiwayatKelas($data)
    {
        $result = [];
        $groupedByTahunAjaran = [];

        // Group by tahun_ajaran_id
        foreach ($data as $item) {
            $tahunAjaranId = $item['tahun_ajaran_id'];
            if (!isset($groupedByTahunAjaran[$tahunAjaranId])) {
                $groupedByTahunAjaran[$tahunAjaranId] = [];
            }
            $groupedByTahunAjaran[$tahunAjaranId][] = $item;
        }

        // Process each tahun_ajaran group
        foreach ($groupedByTahunAjaran as $tahunAjaranGroup) {
            $groupedByKelas = [];

            // Group by kelas_id within each tahun_ajaran group
            foreach ($tahunAjaranGroup as $item) {
                $kelasId = $item['kelas_id'];
                if (!isset($groupedByKelas[$kelasId])) {
                    $groupedByKelas[$kelasId] = [
                        'tahun_ajaran_id' => $item['tahun_ajaran_id'],
                        'tahun' => $item['tahun'],
                        'semester' => $item['semester'],
                        'nama_wali_kelas' => $item['nama_wali_kelas'],
                        'nama_kelas' => $item['nama_kelas'],
                        'kelas_id' => $item['kelas_id'],
                        'proyek' => []
                    ];
                }

                // Add project data
                $groupedByKelas[$kelasId]['proyekData'][] = [
                    'proyek_id' => $item['proyek_id'],
                    'judul_proyek' => $item['judul_proyek'],
                    'deskripsi_proyek' => $item['deskripsi_proyek']
                ];
            }

            // Add processed data to result
            $result = array_merge($result, array_values($groupedByKelas));
        }

        return $result;
    }

    public function getRiwayatMapel()
    {
        $dataMapel = GuruMapel::where('guru_mapel.user_id', $this->user['id'])
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'guru_mapel.tahun_ajaran_id')
            ->join('detail_guru_mapel', 'detail_guru_mapel.guru_mapel_id', 'guru_mapel.id')
            ->join('kelas', function (JoinClause $q) {
                $q->on('kelas.id', '=', 'detail_guru_mapel.kelas_id')
                    ->on('kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id');
            })
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->select(
                'mapel.nama_mapel',
                'mapel.id as id_mapel',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
                'kelas.nama as nama_kelas',
                'kelas.id as kelas_id'
            )
            ->orderBy('kelas.nama')
            ->orderBy('tahun_ajaran.id')
            ->get()
            ->toArray();

        return $this->formatDataMapel($dataMapel);
    }

    function formatDataMapel($data)
    {
        $result = [];
        $groupedByTahunAjaran = [];

        // Pertama grouping berdasarkan tahun_ajaran_id
        foreach ($data as $item) {
            $tahunAjaranId = $item['tahun_ajaran_id'];
            if (!isset($groupedByTahunAjaran[$tahunAjaranId])) {
                $groupedByTahunAjaran[$tahunAjaranId] = [];
            }
            $groupedByTahunAjaran[$tahunAjaranId][] = $item;
        }

        // Kemudian untuk setiap grup tahun ajaran, grouping berdasarkan kelas_id
        foreach ($groupedByTahunAjaran as $tahunAjaranId => $tahunAjaranGroup) {
            $groupedByKelas = [];

            foreach ($tahunAjaranGroup as $item) {
                $kelasId = $item['kelas_id'];

                if (!isset($groupedByKelas[$kelasId])) {
                    $groupedByKelas[$kelasId] = [
                        'tahun_ajaran_id' => $item['tahun_ajaran_id'],
                        'tahun' => $item['tahun'],
                        'semester' => $item['semester'],
                        'kelas_id' => $item['kelas_id'],
                        'nama_kelas' => $item['nama_kelas'],
                        'dataMapel' => []
                    ];
                }

                // Menambahkan data mapel
                $groupedByKelas[$kelasId]['dataMapel'][] = [
                    'id_mapel' => $item['id_mapel'],
                    'nama_mapel' => $item['nama_mapel']
                ];
            }

            // Menambahkan hasil grouping kelas ke result
            foreach ($groupedByKelas as $kelasGroup) {
                $result[] = $kelasGroup;
            }
        }

        return $result;
    }
}
