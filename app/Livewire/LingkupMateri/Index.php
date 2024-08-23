<?php

namespace App\Livewire\LingkupMateri;

use Livewire\Component;
use App\Models\LingkupMateri;
use App\Models\DetailGuruMapel;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $selectedLM;
    public $deleteModal;

    public function render()
    {
        return view('livewire.lingkup-materi.index');
    }

    public function destroy()
    {
        try {
            $lm = LingkupMateri::find($this->selectedLM);

            $detailIdUser = DetailGuruMapel::where('detail_guru_mapel.id', '=', $lm->detail_guru_mapel_id)
                ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
                ->where('guru_mapel.user_id', Auth::id())
                ->select('guru_mapel.user_id')
                ->first();

            $this->authorize('create', [LingkupMateri::class, $detailIdUser]);
            if (!$lm) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $lm->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
