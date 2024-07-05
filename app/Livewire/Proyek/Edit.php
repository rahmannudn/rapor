<?php

namespace App\Livewire\Proyek;

use App\Models\Kelas;
use App\Models\Elemen;
use App\Models\Proyek;
use App\Models\Dimensi;
use Livewire\Component;
use App\Models\Subelemen;
use App\Models\WaliKelas;
use App\Models\CapaianFase;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public Proyek $proyek;

    #[Locked]
    public $tahunAjaranAktifId;
    #[Locked]
    public $capaianFaseId;
    #[Locked]
    public $kelas;
    #[Locked]
    public $capaianFase = '';

    public $daftarDimensi;
    public $daftarElemen;
    public $daftarSubelemen;

    public $judulProyek;
    public $deskripsi;
    public $selectedDimensi;
    public $selectedElemen;
    public $selectedSubelemen;

    #[Layout('layouts.app')]
    public function render()
    {
        // mencari data dari tabel wali kelas
        $dataKelas = WaliKelas::join('kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->join('users', 'wali_kelas.user_id', '=', 'users.id')
            ->where('wali_kelas.id', '=', $this->proyek['wali_kelas_id'])
            ->select('kelas.nama as nama_kelas', 'kelas.id as kelas_id', 'users.name as nama_guru')
            ->first();

        return view('livewire.proyek.edit', compact('dataKelas'));
    }

    public function mount()
    {
        $this->judulProyek = $this->proyek['judul_proyek'];
        $this->deskripsi = $this->proyek['deskripsi'];
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
        $this->selectedDimensi = $this->proyek['dimensi_id'];
        $this->kelas = Proyek::joinWaliKelas()->select('wali_kelas.kelas_id as id')->first();

        // show elemen
        $this->getElemen();
        $this->selectedElemen = $this->proyek['elemen_id'];
        // show subelemen
        $this->getSubelemen();
        $this->selectedSubelemen = $this->proyek['subelemen_id'];
        // show capaian fase
        $this->getCapaianFase();
        $this->capaianFaseId = $this->proyek['capaian_fase_id'];
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
            $faseKelas = Kelas::where('id', '=', $this->kelas['id'])->first();

            $data = CapaianFase::where('subelemen_id', '=', $this->selectedSubelemen)
                ->where('fase', '=', $faseKelas['fase'])
                ->select('deskripsi', 'id')
                ->first();

            $this->capaianFase = $data['deskripsi'];
            $this->capaianFaseId = $data['id'];
        }
    }

    public function update(Proyek $proyek)
    {
        $this->authorize('update', Proyek::class);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required|string',
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'selectedSubelemen' => 'required',
        ]);

        $proyek->update([
            'dimensi_id' => $validated['selectedDimensi'],
            'elemen_id' => $validated['selectedElemen'],
            'subelemen_id' => $validated['selectedSubelemen'],
            'capaian_fase_id' => $this->capaianFaseId,
            'wali_kelas_id' => $this->proyek['wali_kelas_id'],
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi']
        ]);

        session()->flash('success', 'Data Berhasil Dirubah');
        $this->redirectRoute('proyekIndex');
    }
}
