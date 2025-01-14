<?php

namespace App\Livewire\HomePage;

use App\Models\Siswa;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $nisn;
    public $tgl_lahir;
    public $tempat_lahir;

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.homepage.index');
    }

    public function cariSiswa()
    {
        $validated =  $this->validate(
            [
                'nisn' => 'required',
                'tgl_lahir' => 'required|date|date_format:Y-m-d',
                'tempat_lahir' => 'required',
            ]
        );


        $data = Siswa::where('nisn', $validated['nisn'])
            ->where('tanggal_lahir', $validated['tgl_lahir'])
            ->where('tempat_lahir', Str::lower($validated['tempat_lahir']))
            ->first();
        if (empty($data)) {
            session()->flash('errorMessage', 'Data Tidak Ditemukan');
            return;
        }
        session()->flash('errorMessage', $data['nama']);
    }
}
