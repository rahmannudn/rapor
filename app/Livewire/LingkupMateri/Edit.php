<?php

namespace App\Livewire\LingkupMateri;

use Livewire\Component;
use App\Models\LingkupMateri;
use Livewire\Attributes\Layout;
use App\Models\TujuanPembelajaran;

class Edit extends Component
{
    public LingkupMateri $lingkupMateri;

    public $namaGuru;
    public $kelas;
    public $deskripsi;
    public $namaMapel;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.lingkup-materi.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->lingkupMateri['deskripsi'];

        // mendapatkan informasi terkait data yang di edit
        $data = LingkupMateri::joinDetailGuruMapel()
            ->joinGuruMapel()
            ->joinMapel()
            ->joinKelas()
            ->joinUsers()
            ->select(
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
            )
            ->firstWhere('lingkup_materi.id', '=', $this->lingkupMateri['id']);

        $this->namaGuru = $data['nama_guru'];
        $this->kelas = $data['nama_kelas'];
        $this->namaMapel = $data['nama_mapel'];
    }

    public function update(LingkupMateri $lm)
    {
        $this->authorize('update', LingkupMateri::class);

        $validated = $this->validate([
            'deskripsi' => 'required|string|min:3',
        ]);

        if ($this->lingkupMateri['deskripsi'] == $this->deskripsi) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $lm->update(
            ['deskripsi' => $validated['deskripsi']]
        );

        $this->redirectRoute('lingkupMateriIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
