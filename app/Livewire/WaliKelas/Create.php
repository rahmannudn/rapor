<?php

namespace App\Livewire\WaliKelas;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\WaliKelas;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

class Create extends Component
{
    public $daftarKelas;
    public $daftarGuru;

    #[Locked]
    public $tahunAjaranAktif;

    public $kelas;
    public $guru;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.wali-kelas.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::all();
        $this->daftarGuru = User::select('id', 'name')->where('role', 'guru')->get();
        $this->tahunAjaranAktif = TahunAjaran::select('id')->where('aktif', 1)->first();

        if (!$this->tahunAjaranAktif) {
            $this->redirectRoute('waliKelasIndex');
            session()->flash('gagal', 'Harus ada Tahun Ajaran yang aktif!!');
        }
    }

    public function save()
    {
        if (!$this->tahunAjaranAktif) {
            session()->flash('gagal', 'Harus ada Tahun Ajaran yang aktif!!');
        }

        $validated = $this->validate([
            'kelas' => 'required',
            'guru' => 'required',
        ]);

        WaliKelas::create([
            'id_kelas' => $validated['kelas'],
            'id_user' => $validated['guru'],
            'id_tahun_ajaran' => $this->tahunAjaranAktif['id'],
        ]);

        $this->redirectRoute('waliKelasIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
