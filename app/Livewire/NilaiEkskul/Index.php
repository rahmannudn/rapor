<?php

namespace App\Livewire\NilaiEkskul;

use App\Models\NilaiEkskul;
use Livewire\Component;

class Index extends Component
{
    public $selectedNilai;
    public $deleteModal;

    public function render()
    {
        return view('livewire.nilai-ekskul.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', [NilaiEkskul::class, $this->selectedNilai]);

            $nilai = NilaiEkskul::find($this->selectedNilai);
            if (!$nilai) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'nilai Tidak Ditemukan', icon: 'success');
            }
            $nilai->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->deleteModal = false;
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
