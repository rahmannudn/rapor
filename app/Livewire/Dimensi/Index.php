<?php

namespace App\Livewire\Dimensi;

use App\Models\Dimensi;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $dataDimensi;
    public $selectedDimensi;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.dimensi.index');
    }

    public function destroy()
    {
        try {
            $dimensi = Dimensi::find($this->selectedDimensi);
            if (!$dimensi) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'dimensi Tidak Ditemukan', icon: 'success');
                $this->deleteModal = false;
            }
            $this->authorize('delete', Dimensi::class);
            $dimensi->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
