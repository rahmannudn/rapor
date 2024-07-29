<?php

namespace App\Livewire\MateriMapel;

use App\Models\MateriMapel;
use Livewire\Component;

class Index extends Component
{
    public $selectedMateri;
    public $deleteModal;

    public function render()
    {
        return view('livewire.materi-mapel.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', MateriMapel::class);

            $materi = MateriMapel::find($this->selectedMateri);
            if (!$materi) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $materi->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
