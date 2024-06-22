<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Index extends Component
{
    public $selectedSiswa;
    public $deleteModal;

    #[Title('Siswa')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.siswa.index');
    }

    public function destroy()
    {
        try {
            $siswa = Siswa::find($this->selectedSiswa);
            if (!$siswa) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Siswa Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $siswa);
            $siswa->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
