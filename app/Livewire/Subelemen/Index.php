<?php

namespace App\Livewire\Subelemen;

use App\Models\Subelemen;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $selectedSubelemen;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.subelemen.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', Subelemen::class);

            $subelemen = Subelemen::find($this->selectedsubelemen);
            if (!$subelemen) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $subelemen->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
