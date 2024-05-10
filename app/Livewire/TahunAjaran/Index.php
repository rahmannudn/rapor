<?php

namespace App\Livewire\TahunAjaran;

use App\Models\TahunAjaran as TA;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\Attributes\Title;

class Index extends Component
{
    use Actions;

    public $selectedTahunAjaran;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tahun-ajaran.index');
    }

    public function destroy()
    {
        try {
            $tahunAjaran = TA::find($this->selectedTahunAjaran);
            if (!$tahunAjaran) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Note Tidak Ditemukan', icon: 'success');
            }
            $this->authorize('delete', $tahunAjaran);
            $tahunAjaran->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
