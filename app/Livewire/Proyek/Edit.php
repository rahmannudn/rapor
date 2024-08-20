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
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public Proyek $proyek;

    #[Locked]
    public $tahunAjaranAktifId;
    #[Locked]
    public $kelas;

    public $judulProyek;
    public $deskripsi;

    public function render()
    {
        return view('livewire.proyek.edit');
    }

    public function mount()
    {
        $dataKelas = WaliKelas::searchAndJoinKelas($this->proyek['wali_kelas_id'])
            ->join('users', 'wali_kelas.user_id', '=', 'users.id')
            ->select('kelas.nama as nama_kelas', 'users.name as nama_guru')
            ->first();

        $this->kelas = $dataKelas['nama_kelas'] . ' - ' . ucfirst($dataKelas['nama_guru']);

        $this->judulProyek = $this->proyek['judul_proyek'];
        $this->deskripsi = $this->proyek['deskripsi'];

        // $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
        // $this->selectedDimensi = $this->proyek['dimensi_id'];
        // // show elemen
        // $this->getElemen();
        // $this->selectedElemen = $this->proyek['elemen_id'];
        // // show subelemen
        // $this->getSubelemen();
        // $this->selectedSubelemen = $this->proyek['subelemen_id'];
        // // show capaian fase
        // $this->getCapaianFase();
        // $this->capaianFaseId = $this->proyek['capaian_fase_id'];
    }

    public function update(Proyek $proyek)
    {
        $this->authorize('update', $proyek);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $proyek->update([
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi']
        ]);

        session()->flash('success', 'Data Berhasil Dirubah');
        $this->redirectRoute('proyekIndex');
    }
}
