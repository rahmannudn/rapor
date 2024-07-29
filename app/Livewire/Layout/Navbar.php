<?php

namespace App\Livewire;

use App\Models\Sekolah;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Navbar extends Component
{
    // public function mount()
    // {
    //     $this->checkAndSetSekolahSession();
    // }

    // public function checkAndSetSekolahSession()
    // {
    //     if (
    //         session()->missing('nama_sekolah') && session()->missing('logo_sekolah')
    //     ) {
    //         $sekolahData = Sekolah::select('logo_sekolah', 'nama_sekolah')->get()->toArray()[0];

    //         // session()->put('nama_sekolah', $sekolahData['nama_sekolah']);
    //         Session::put('nama_sekolah', $sekolahData['nama_sekolah']);
    //         Session::put('logo_sekolah', $sekolahData['logo_sekolah']);
    //     }
    // }

    public function render()
    {
        return view('livewire.layout.navbar');
    }
}
