<?php

namespace App\Livewire\TujuanPembelajaran;

use Livewire\Component;
use App\Models\DetailGuruMapel;
use App\Models\TujuanPembelajaran;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $selectedTP;
    public $deleteModal;

    public function render()
    {
        return view('livewire.tujuan-pembelajaran.index');
    }

    public function destroy()
    {
        try {
            $tp = TujuanPembelajaran::find($this->selectedTP);
            if (!$tp) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $detailIdUser = DetailGuruMapel::where('detail_guru_mapel.id', '=', $tp->detail_guru_mapel_id)
                ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
                ->where('guru_mapel.user_id', Auth::id())
                ->select('guru_mapel.user_id')
                ->first();

            $this->authorize('create', [TujuanPembelajaran::class, $detailIdUser]);
            $tp->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
