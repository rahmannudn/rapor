<?php

namespace App\Livewire\Kepsek;

use App\Models\Kepsek;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $dataKepsek;
    public $selectedKepsek;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.kepsek.index');
    }

    public function destroy()
    {
        try {
            $kepsek = Kepsek::find($this->selectedKepsek);
            if (!$kepsek) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Kepsek Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kepsek);
            $kepsek->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
