<?php

namespace App\Livewire\TujuanPembelajaran;

use Livewire\Component;
use App\Models\DetailGuruMapel;
use App\Models\TujuanPembelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public TujuanPembelajaran $tujuanPembelajaran;

    #[Locked]
    public $detailGuruMapelId;

    public $namaGuru;
    public $kelas;
    public $deskripsi;
    public $namaMapel;

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
                'detail_guru_mapel.id as detail_guru_mapel_id'
            )
            ->firstWhere('tujuan_pembelajaran.id', '=', $this->tujuanPembelajaran['id']);

        $this->namaGuru = $data['nama_guru'];
        $this->kelas = $data['nama_kelas'];
        $this->namaMapel = $data['nama_mapel'];
        $this->detailGuruMapelId = $data['detail_guru_mapel_id'];
    }

    public function update(TujuanPembelajaran $tp)
    {
        $detailIdUser = DetailGuruMapel::where('detail_guru_mapel.id', '=', $this->detailGuruMapelId)
            ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
            ->where('guru_mapel.user_id', Auth::id())
            ->select('guru_mapel.user_id')
            ->first();

        $this->authorize('create', [TujuanPembelajaran::class, $detailIdUser]);

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
