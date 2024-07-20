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
    public $judul;
    public $kelas;
    public $fase;
    public $tahunAjaran;
    public $waliKelas;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.subproyek.index');
    }

    public function mount()
    {
        $this->judul = $this->proyek['judul_proyek'];
        $data = FunctionHelper::getKelasInfo($this->proyek['wali_kelas_id']);

        if ($data) {
            $this->kelas = $data['nama_kelas'];
            $this->fase = $data['fase'];
            $this->tahunAjaran = $data['tahun'] . ' - ' . ucfirst($data['semester']);
        }

        if (Gate::allows('superAdminOrKepsek')) {
            $this->waliKelas = WaliKelas::where('wali_kelas.id', '=', $this->proyek['wali_kelas_id'])->joinUser()->select('users.name as nama_wali')->first();
        }
    }
}
