<?php

namespace App\Livewire\LingkupMateri;

use Livewire\Component;
use App\Models\LingkupMateri;
use App\Models\DetailGuruMapel;
use App\Models\TujuanPembelajaran;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public LingkupMateri $lingkupMateri;

    public $namaGuru;
    public $kelas;
    public $deskripsi;
    public $namaMapel;

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
        $detailIdUser = DetailGuruMapel::where('detail_guru_mapel.id', '=', $lm->detail_guru_mapel_id)
            ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
            ->where('guru_mapel.user_id', Auth::id())
            ->select('guru_mapel.user_id')
            ->first();

        $this->authorize('create', [LingkupMateri::class, $detailIdUser]);

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
