<?php

namespace App\Livewire\NilaiSubproyek;

use App\Helpers\FunctionHelper;
use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\CatatanProyek;
use App\Models\Kelas;
use App\Models\NilaiProyek;
use App\Models\NilaiSubproyek;
use App\Models\Proyek;
use Illuminate\Support\Facades\Gate;

class Table extends Component
{
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;
    public $nilaiData;
    public $proyekData;

    public $judul;
    public $kelas;
    public $fase;
    public $tahunAjaran;
    public $waliKelas;

    public function render()
    {
        return view('livewire.nilai-subproyek.table');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', NilaiSubproyek::class)) {
            $this->daftarKelas = FunctionHelper::getDaftarKelasHasProyek($this->tahunAjaranAktif);

            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')
                ->orderBy('created_at')
                ->get();
        }

        if (Gate::allows('guru')) {
        }
    }

    public function showForm()
    {
        $this->validate(
            ['selectedKelas' => 'required'],
            ['selectedKelas.required' => 'Kelas field is required.',]
        );
        if (is_null($this->selectedKelas)) return;

        $this->formCreate = true;
    }

    public function getKelasInfo()
    {
        $this->judul = '';
        $this->kelas = '';
        $this->fase = '';
        $this->tahunAjaran = '';
        $this->waliKelas = '';
    }

    public function getNilai()
    {
        $this->nilaiData = '';
        $this->proyekData = '';

        // if ($this->selectedKelas && $this->tahunAjaranAktif) {
        //     $this->proyekData = Proyek::joinWaliKelas()
        //         ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
        //         ->where('wali_kelas.kelas_id', $this->selectedKelas)
        //         ->joinDimensi()
        //         ->joinCapaianFase()
        //         ->select(
        //             'proyek.id',
        //             'proyek.judul_proyek',
        //             'dimensi.deskripsi as dimensi_deskripsi',
        //             'capaian_fase.deskripsi as capaian_fase_deskripsi'
        //         )
        //         ->orderBy('proyek.created_at')
        //         ->get();

        //     dump($this->proyekData);
        // }
    }
}
