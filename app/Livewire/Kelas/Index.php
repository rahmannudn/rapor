<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;

use Livewire\Component;

class Index extends Component
{
    public $dataKelas;
    public $selectedKelas;
    public $deleteModal;

    public function render()
    {
        return view('livewire.kelas.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', Kelas::class);

            $kelas = Kelas::find($this->selectedKelas);
            if (!$kelas) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Kelas Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kelas);
            $kelas->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
