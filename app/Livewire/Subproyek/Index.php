<?php

namespace App\Livewire\Subproyek;

use App\Helpers\FunctionHelper;
use App\Models\Proyek;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public Proyek $proyek;

    public $kelasInfo = [];

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.subproyek.index');
    }

    public function mount()
    {
        $this->kelasInfo['judul'] = $this->proyek['judul_proyek'];
        $data = FunctionHelper::getKelasInfo($this->proyek['wali_kelas_id']);

        if ($data) {
            $this->kelasInfo['namaKelas'] = $data['nama_kelas'];
            $this->kelasInfo['fase'] = $data['fase'];
            $this->kelasInfo['tahunAjaran'] = $data['tahun'] . ' - ' . ucfirst($data['semester']);
        }

        if (Gate::allows('superAdminOrKepsek')) {
            $kelas = WaliKelas::where('wali_kelas.id', '=', $this->proyek['wali_kelas_id'])
                ->joinUser()
                ->select('users.name as nama_wali', 'wali_kelas.id as wali_kelas_id')
                ->first();

            $this->kelasInfo['namaWaliKelas'] = $kelas['nama_wali'];
            $this->kelasInfo['waliKelasId'] = $kelas['wali_kelas_id'];
        }
    }
}
