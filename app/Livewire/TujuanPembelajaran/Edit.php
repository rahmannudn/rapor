<?php

namespace App\Livewire\TujuanPembelajaran;

use App\Models\TujuanPembelajaran;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Edit extends Component
{
    public TujuanPembelajaran $tujuanPembelajaran;

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
        $this->deskripsi = $this->tujuanPembelajaran['deskripsi'];

        // mendapatkan informasi terkait data yang di edit
        $data = TujuanPembelajaran::joinDetailGuruMapel()
            ->joinGuruMapel()
            ->joinMapel()
            ->joinKelas()
            ->joinUsers()
            ->select(
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
            )
            ->firstWhere('tujuan_pembelajaran.id', '=', $this->tujuanPembelajaran['id']);

        $this->namaGuru = $data['nama_guru'];
        $this->kelas = $data['nama_kelas'];
        $this->namaMapel = $data['nama_mapel'];
    }

    public function update(TujuanPembelajaran $tp)
    {
        $this->authorize('update', TujuanPembelajaran::class);

        $validated = $this->validate([
            'deskripsi' => 'required|string|min:3',
        ]);

        if ($this->tujuanPembelajaran['deskripsi'] == $this->deskripsi) {
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
