<?php

namespace App\Livewire\Proyek;

use App\Models\Proyek;
use App\Models\WaliKelas;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public Proyek $proyek;

    public $judulProyek;
    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        $dataKelas = WaliKelas::join('kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->join('users', 'wali_kelas.user_id', '=', 'users.id')
            ->where('kelas.id', '=', $this->proyek['id'])
            ->select('kelas.nama as nama_kelas', 'users.name as nama_guru')
            ->first();

        return view('livewire.proyek.edit', compact('dataKelas'));
    }

    public function mount()
    {
        $this->judulProyek = $this->proyek['judul_proyek'];
        $this->deskripsi = $this->proyek['deskripsi'];
    }

    public function update(Proyek $proyek)
    {
        $this->authorize('update', Proyek::class);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        $proyek->update([
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi']
        ]);

        session()->flash('success', 'Data Berhasil Dirubah');
        $this->redirectRoute('proyekIndex');
    }
}
