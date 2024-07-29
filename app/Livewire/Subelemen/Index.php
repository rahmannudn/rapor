<?php

namespace App\Livewire\Subelemen;

use App\Models\Subelemen;
use Livewire\Component;

class Index extends Component
{
    public $selectedSubelemen;
    public $deleteModal;

    public function render()
    {
        return view('livewire.subelemen.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', Subelemen::class);

            $subelemen = Subelemen::find($this->selectedSubelemen);
            if (!$subelemen) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $subelemen->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
            $this->deleteModal = false;
        }
    }
}
