<?php

namespace App\Livewire\Proyek;

use App\Models\CapaianFase;
use App\Models\Kelas;
use App\Models\Elemen;
use App\Models\Proyek;
use App\Models\Dimensi;
use Livewire\Component;

use App\Models\Subelemen;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Gate;

class Create extends Component
{
    #[Locked]
    public $tahunAjaranAktifId;
    #[Locked]
    public $capaianFaseId;
    #[Locked]
    public $kelasId;

    public $tahunAjaranAktif;
    public $daftarDimensi;
    public $daftarElemen;
    public $daftarSubelemen;
    public $capaianFase = '';

    public $createForm;
    public $selectedWaliKelas;
    public $selectedDimensi;
    public $selectedElemen;
    public $selectedSubelemen;

    public $judulProyek;
    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        $this->tahunAjaranAktif = TahunAjaran::select('id', 'tahun', 'semester')->firstWhere('aktif', 1);
        $this->tahunAjaranAktifId = $this->tahunAjaranAktif['id'];
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();

        $daftarWaliKelas = '';
        if (Gate::allows('isSuperAdmin')) {
            $daftarWaliKelas = WaliKelas::where('tahun_ajaran_id', '=', $this->tahunAjaranAktifId)
                ->joinUser()
                ->joinKelas()
                ->select('wali_kelas.id as wali_kelas_id', 'kelas.id as kelas_id', 'users.name as nama', 'kelas.nama as nama_kelas')
                ->get();
        }

        return view('livewire.proyek.create', compact('daftarWaliKelas'));
    }

    public function extractId($value)
    {
        list($waliKelasId, $kelasId) = explode('/', $value);
        return ['wali_kelas_id' => $waliKelasId, 'kelas_id' => $kelasId];
    }

    public function showForm()
    {
        $validated = $this->validate([
            'selectedWaliKelas' => 'required'
        ], ['selectedWaliKelas.required' => 'Wali Kelas field is required.']);

        $ids = $this->extractId($validated['selectedWaliKelas']);
        $this->kelasId = $ids['kelas_id'];

        if (Gate::allows('isSuperAdmin')) {
            $this->validate(
                ['tahunAjaranAktif' => 'required'],
                ['tahunAjaranAktif.required' => 'Tahun Ajaran field is required.']
            );
        }

        $this->createForm = true;
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
        $ids = $this->extractId($this->selectedWaliKelas);
        $kelasId = $ids['kelas_id'];

        if ($this->selectedDimensi && $this->selectedElemen && $this->selectedSubelemen && $this->selectedWaliKelas) {
            $faseKelas = Kelas::where('id', '=', $kelasId)->select('fase')->first();
            $data = CapaianFase::where('subelemen_id', '=', $this->selectedSubelemen)->where('fase', '=', $faseKelas['fase'])->select('deskripsi', 'id')->first();
            $this->capaianFase = $data['deskripsi'];
            $this->capaianFaseId = $data['id'];
        }
    }

    public function save()
    {
        $this->authorize('create', Proyek::class);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required',
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'selectedSubelemen' => 'required',
            'selectedWaliKelas' => 'required',
        ]);

        $ids = $this->extractId($validated['selectedWaliKelas']);

        Proyek::create([
            'dimensi_id' => $validated['selectedDimensi'],
            'elemen_id' => $validated['selectedElemen'],
            'subelemen_id' => $validated['selectedSubelemen'],
            'capaian_fase_id' => $this->capaianFaseId,
            'wali_kelas_id' => $ids['wali_kelas_id'],
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('proyekIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
