<?php

namespace App\Livewire\Prestasi;

use App\Models\Prestasi;
use Livewire\Component;

class Index extends Component
{
    public $selectedPrestasi;
    public $deleteModal;

    public function render()
    {
        return view('livewire.prestasi.index');
    }

    public function destroy()
    {
        $this->authorize('delete', Prestasi::class);

        $prestasi = Prestasi::find($this->selectedPrestasi);
        if (!$prestasi) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Kelas Tidak Ditemukan', icon: 'success');
        }
        $prestasi->delete();

        session()->flash('success', 'Data Berhasil Dihapus');
        $this->dispatch('updateData');
        $this->deleteModal = false;
    }
}
