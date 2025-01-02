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

        $subproyek = $this->getSubProyekInfo();

        return view('livewire.proyek.detail', [
            'nama_kelas' => $dataWali['nama_kelas'],
            'nama_wali_kelas' => $dataWali['nama_wali_kelas'],
            'tahun' => $dataWali['tahun'],
            'semester' => $dataWali['semester'],
            'subproyek' => $subproyek,
        ]);
    }

    private function getSubProyekInfo()
    {
        return Proyek::where('proyek.id', $this->proyek['id'])
            ->join('subproyek', 'subproyek.proyek_id', 'proyek.id')
            ->join('capaian_fase', 'capaian_fase.id', 'subproyek.capaian_fase_id')
            ->join('subelemen', 'subelemen.id', 'capaian_fase.subelemen_id')
            ->join('elemen', 'elemen.id', 'subelemen.elemen_id')
            ->join('dimensi', 'dimensi.id', 'elemen.dimensi_id')
            ->select(
                'subproyek.id',
                'capaian_fase.deskripsi as capaian_fase_deskripsi',
                'subelemen.deskripsi as subelemen_deskripsi',
                'elemen.deskripsi as elemen_deskripsi',
                'dimensi.deskripsi as dimensi_deskripsi',
            )
            ->get();
    }
}
