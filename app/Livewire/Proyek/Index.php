<?php

namespace App\Livewire\Proyek;

use App\Models\Proyek;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $dataProyek;
    public $selectedProyek;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.proyek.index');
    }

    public function destroy()
    {
        try {
            $proyek = Proyek::find($this->selectedProyek);
            if (!$proyek) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'proyek Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $proyek);
            $proyek->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
