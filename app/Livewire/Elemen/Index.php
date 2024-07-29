<?php

namespace App\Livewire\Elemen;

use App\Models\Elemen;
use Livewire\Component;

class Index extends Component
{
    public $dataElemen;
    public $selectedElemen;
    public $deleteModal;

    public function render()
    {
        return view('livewire.elemen.index');
    }

    public function destroy()
    {
        try {
            $elemen = Elemen::find($this->selectedElemen);
            if (!$elemen) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Elemen Tidak Ditemukan', icon: 'success');
                $this->deleteModal = false;
            }
            $this->authorize('delete', Elemen::class);
            $elemen->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
