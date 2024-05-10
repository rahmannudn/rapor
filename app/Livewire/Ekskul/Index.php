<?php

namespace App\Livewire\Ekskul;

use App\Models\Ekskul;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $dataEkskul;
    public $selectedEkskul;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.ekskul.index');
    }

    public function destroy()
    {
        try {
            $ekskul = Ekskul::find($this->selectedEkskul);
            if (!$ekskul) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kelas);
            $ekskul->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
