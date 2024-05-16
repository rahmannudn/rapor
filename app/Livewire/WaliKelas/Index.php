<?php

namespace App\Livewire\WaliKelas;

use App\Models\WaliKelas;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $dataWali;
    public $selectedWali;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.wali-kelas.index');
    }

    public function destroy()
    {
        try {
            $waliKelas = WaliKelas::find($this->selectedWali);
            if (!$waliKelas) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Wali Kelas Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kelas);
            $waliKelas->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
