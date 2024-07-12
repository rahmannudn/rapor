<?php

namespace App\Livewire\LingkupMateri;

use Livewire\Component;
use App\Models\LingkupMateri;
use Livewire\Attributes\Layout;
use App\Models\TujuanPembelajaran;

class Edit extends Component
{
    public LingkupMateri $lingkup_materi;

    public $namaGuru;
    public $kelas;
    public $deskripsi;
    public $namaMapel;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tujuan-pembelajaran.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->lingkup_materi['deskripsi'];

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
            ->firstWhere('tujuan_pembelajaran.id', '=', $this->lingkup_materi['id']);

        $this->namaGuru = $data['nama_guru'];
        $this->kelas = $data['nama_kelas'];
        $this->namaMapel = $data['nama_mapel'];
    }

    public function update(LingkupMateri $tp)
    {
        $this->authorize('update', LingkupMateri::class);

        $validated = $this->validate([
            'deskripsi' => 'required|string|min:3',
        ]);

        if ($this->lingkup_materi['deskripsi'] == $this->deskripsi) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $tp->update(
            ['deskripsi' => $validated['deskripsi']]
        );

        $this->redirectRoute('tujuanPembelajaranIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
