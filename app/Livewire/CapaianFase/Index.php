<?php

namespace App\Livewire\CapaianFase;

use App\Models\CapaianFase;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $selectedCapaianFase;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.capaian-fase.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', CapaianFase::class);

            $capaianfase = CapaianFase::find($this->selectedCapaianFase);
            if (!$capaianfase) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $capaianfase->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
            $this->deleteModal = false;
        }
    }
}
