<?php

namespace App\Livewire\Layouts;

use App\Models\Sekolah;
use Livewire\Component;

class App extends Component
{
    public function mount()
    {
        dump('kocak');
        $this->checkAndSetSekolahSession();
    }

    public function checkAndSetSekolahSession()
    {
        if (
            session()->missing('nama_sekolah') && session()->missing('logo_sekolah')
        ) {
            $sekolahData = Sekolah::select('logo_sekolah', 'nama_sekolah')->get()->toArray()[0];

            // session()->put('nama_sekolah', $sekolahData['nama_sekolah']);
            session()->put('nama_sekolah', $sekolahData['nama_sekolah']);
            session()->put('logo_sekolah', $sekolahData['logo_sekolah']);
        }
    }

    public function render()
    {
        return view('livewire.layouts.app');
    }
}
