<?php

namespace App\Livewire\GuruMapel;

use App\Models\GuruMapel;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $dataGuru;
    public $selectedGuruMapel;
    public $deleteModal;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.guru-mapel.index');
    }

    public function destroy()
    {
        try {
            $guruMapel = GuruMapel::find($this->seletedGuruMapel);
            if (!$guruMapel) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $kelas);
            $guruMapel->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
