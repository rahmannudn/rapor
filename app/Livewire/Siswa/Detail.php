<?php

namespace App\Livewire\Siswa;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Database\Query\JoinClause;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Detail extends Component
{
    public Siswa $siswa;
    public $riwayatKelasProyek;

    public function mount()
    {
        $this->riwayatKelasProyek = $this->getRiwayatProyek();
    }

    public function render()
    {
        return view('livewire.siswa.detail');
    }

    public function getRiwayatProyek()
    {
        $proyekData = KelasSiswa::where('kelas_siswa.siswa_id', $this->siswa['id'])
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas.id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas_siswa.tahun_ajaran_id')
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->join('proyek', 'proyek.wali_kelas_id', 'wali_kelas.id')
            ->leftJoin('catatan_proyek', function (JoinClause $q) {
                $q->on('catatan_proyek.proyek_id', '=', 'proyek.id')
                    ->on('catatan_proyek.siswa_id', '=', 'kelas_siswa.siswa_id');
            })
            ->select(
                'kelas_siswa.id as kelas_siswa_id',
                'kelas.nama as nama_kelas',
                'users.name as nama_wali_kelas',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
                'proyek.id as proyek_id',
                'proyek.judul_proyek',
                'proyek.deskripsi as deskripsi_proyek',
                'catatan_proyek.id as catatan_proyek_id',
                'catatan_proyek.catatan',
            )
            ->orderBy('kelas.nama')
            ->orderBy('tahun_ajaran.id')
            ->get()
            ->toArray();

        return $this->processData($proyekData);
    }

    function processData($data)
    {
        $result = [];
        $groupedData = [];

        // Group data by tahun_ajaran_id
        foreach ($data as $item) {
            $tahunAjaranId = $item['tahun_ajaran_id'];
            if (!isset($groupedData[$tahunAjaranId])) {
                $groupedData[$tahunAjaranId] = [
                    'kelas_siswa_id' => $item['kelas_siswa_id'],
                    'nama_kelas' => $item['nama_kelas'],
                    'nama_wali_kelas' => $item['nama_wali_kelas'],
                    'tahun_ajaran_id' => $item['tahun_ajaran_id'],
                    'tahun' => $item['tahun'],
                    'semester' => $item['semester'],
                    'proyekData' => []
                ];
            }

            // Add project data to the group
            $groupedData[$tahunAjaranId]['proyekData'][] = [
                'proyek_id' => $item['proyek_id'],
                'judul_proyek' => $item['judul_proyek'],
                'deskripsi_proyek' => $item['deskripsi_proyek'] ?? '',
                'catatan_proyek_id' => $item['catatan_proyek_id'] ?? '',
                'catatan' => $item['catatan'] ?? '',
            ];
        }

        // Convert grouped data to the desired output format
        foreach ($groupedData as $group) {
            $result[] = $group;
        }

        return $result;
    }
}
