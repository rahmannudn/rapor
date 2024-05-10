<?php

namespace App\Livewire\Mapel;

use App\Models\Mapel;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $dataMapel;
    public $selectedMapel;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.mapel.index');
    }

    public function destroy()
    {
        try {
            $mapel = Mapel::find($this->selectedMapel);
            if (!$mapel) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kelas);
            $mapel->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
