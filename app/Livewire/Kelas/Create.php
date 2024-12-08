<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Create extends Component
{
    public $kelas;
    public $nama;
    public $fase;

    public function render()
    {
        return view('livewire.kelas.create');
    }

    public function save()
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->authorize('create', Kelas::class);

        $validated = $this->validate([
            'nama' => 'required|string|min:3|max:10',
            'kelas' => 'required',
            'fase' => 'required',
            'tahun_ajaran_id' => $tahunAjaranAktif,
        ]);

        Kelas::create($validated);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('kelasIndex');
    }
}
