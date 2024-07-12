<?php

namespace App\Livewire\TujuanPembelajaran;

use App\Models\TujuanPembelajaran;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $selectedTP;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tujuan-pembelajaran.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', TujuanPembelajaran::class);

            $tp = TujuanPembelajaran::find($this->selectedTP);
            if (!$tp) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $tp->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
