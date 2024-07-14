<?php

namespace App\Livewire\CatatanProyek;

use App\Models\CatatanProyek;
use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Gate;

class Table extends Component
{
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;

    public function render()
    {
        return view('livewire.catatan-proyek.table');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', CatatanProyek::class)) {
            $this->daftarKelas = Kelas::query()
                ->joinWaliKelas($this->tahunAjaranAktif)
                ->select('kelas.id', 'kelas.nama')
                ->get();

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

    public function getCatatan()
    {
        if ($this->selectedKelas && $this->tahunAjaranAktif) {
            $data = CatatanProyek::joinProyek()->joinSiswa();
        }
    }
}
