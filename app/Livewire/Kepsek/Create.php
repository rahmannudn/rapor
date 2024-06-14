<?php

namespace App\Livewire\Kepsek;

use App\Models\User;
use App\Models\Kepsek;
use Livewire\Component;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;

class Create extends Component
{
    public $daftarTahunAjaran;
    public $daftarKepsek;

    public $periodeAwal;
    public $periodeAkhir;
    public $selectedKepsek;
    public $aktif;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.kepsek.create');
    }

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::select('tahun', 'semester', 'aktif', 'id')
            ->orderBy('tahun')
            ->get();
        $this->daftarKepsek = User::where('role', '=', 'kepsek')
            ->select('id', 'name', 'email', 'jk', 'jenis_pegawai')
            ->orderBy('name')
            ->get();
    }

    public function save()
    {
        $this->authorize('create', Kepsek::class);

        $validated = $this->validate([
            'selectedKepsek' => 'required',
            'periodeAwal' => 'required',
        ], [
            'selectedKepsek.required' => 'Kepsek field is required.',
            'periodeAwal.required' => 'Periode Awal field is required.',
        ]);

        Kepsek::create([
            'user_id' => $validated['selectedKepsek'],
            'awal_menjabat' => $validated['periodeAwal'],
            'akhir_menjabat' => $this->periodeAkhir,
            'aktif' => $this->aktif
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('kepsekIndex');
    }
}
