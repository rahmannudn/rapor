<?php

namespace App\Livewire\Proyek;

use App\Models\Proyek;
use App\Models\WaliKelas;
use Livewire\Component;

class Detail extends Component
{
    public Proyek $proyek;

    public function render()
    {
        $dataWali = WaliKelas::where('wali_kelas.id', $this->proyek['wali_kelas_id'])
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'wali_kelas.tahun_ajaran_id')
            ->select('kelas.nama as nama_kelas', 'users.name as nama_wali_kelas', 'tahun_ajaran.tahun', 'tahun_ajaran.semester')
            ->first()
            ->toArray();

        return view('livewire.proyek.detail', [
            'nama_kelas' => $dataWali['nama_kelas'],
            'nama_wali_kelas' => $dataWali['nama_wali_kelas'],
            'tahun' => $dataWali['tahun'],
            'semester' => $dataWali['semester'],
        ]);
    }
}
