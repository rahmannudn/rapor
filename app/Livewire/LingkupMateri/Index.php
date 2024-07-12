<?php

namespace App\Livewire\LingkupMateri;

use App\Models\LingkupMateri;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $selectedTP;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.lingkup-materi.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', LingkupMateri::class);

            $lm = LingkupMateri::find($this->selectedTP);
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
