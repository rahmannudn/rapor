<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $selectedUser;
    public $deleteModal;

    public function render()
    {
        return view('livewire.user.index');
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', User::class);

            $user = User::find($this->selectedUser);
            if (!$user) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'User Tidak Ditemukan', icon: 'success');
            }
            // $this->authorize('delete', $user);
            $user->delete();

            session()->flash('success', 'Data Berhasil Dihapus');
            $this->dispatch('updateData');
            $this->deleteModal = false;
        } catch (\Throwable $err) {
            dd($err);
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
