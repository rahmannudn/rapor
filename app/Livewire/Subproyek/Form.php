<?php

namespace App\Livewire\Subproyek;

use App\Models\Kelas;
use App\Models\Elemen;
use App\Models\Dimensi;
use Livewire\Component;
use App\Models\Subelemen;
use App\Models\CapaianFase;
use App\Models\TahunAjaran;
use Livewire\Attributes\Locked;

class Form extends Component
{
    public $fase;
    public $proyekId;

    public $tahunAjaranAktif;
    #[Locked]
    public $tahunAjaranAktifId;
    #[Locked]
    public $capaianFaseId;

    public $daftarDimensi;
    public $daftarElemen;
    public $daftarSubelemen;
    public $capaianFase = '';
    public $selectedDimensi;
    public $selectedElemen;
    public $selectedSubelemen;

    public function render()
    {
        $this->tahunAjaranAktif = TahunAjaran::select('id', 'tahun', 'semester')->firstWhere('aktif', 1);
        $this->tahunAjaranAktifId = $this->tahunAjaranAktif['id'];
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();

        return view('livewire.subproyek.form');
    }

    public function getElemen()
    {
        if ($this->selectedDimensi) {
            $this->daftarElemen = '';
            $this->selectedElemen = '';
            $this->daftarSubelemen = '';
            $this->selectedSubelemen = '';
            $this->capaianFase = '';

            $this->daftarElemen = Elemen::select('deskripsi', 'id')
                ->where('dimensi_id', $this->selectedDimensi)
                ->orderBy('created_at')
                ->get();
        }
    }

    public function getSubelemen()
    {
        if ($this->selectedDimensi && $this->selectedElemen) {
            $this->daftarSubelemen = '';
            $this->selectedSubelemen = '';
            $this->capaianFase = '';

            $this->daftarSubelemen = Subelemen::select('deskripsi', 'id')
                ->where('elemen_id', $this->selectedElemen)
                ->orderBy('created_at')
                ->get();
        }
    }

    public function getCapaianFase()
    {
        if ($this->selectedDimensi && $this->selectedElemen && $this->selectedSubelemen) {
            $data = CapaianFase::where('subelemen_id', '=', $this->selectedSubelemen)
                ->where('fase', '=', $this->fase)
                ->select('deskripsi', 'id')->first();
            $this->capaianFase = $data['deskripsi'];
            $this->capaianFaseId = $data['id'];
        }
    }
}
