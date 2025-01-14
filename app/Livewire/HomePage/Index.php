<?php

namespace App\Livewire\HomePage;

use App\Models\Siswa;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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
        if (RateLimiter::tooManyAttempts('submit-form:' . request()->ip(), 5)) {
            throw ValidationException::withMessages([
                'error' => "Terlalu banyak permintaan. Coba lagi dalam beberapa menit.",
            ]);
        }
        // Tambahkan percobaan
        RateLimiter::hit('submit-form:' . request()->ip());

        $validated =  $this->validate(
            [
                'nisn' => 'required',
                'tgl_lahir' => 'required|date|date_format:Y-m-d',
                'tempat_lahir' => 'required',
            ]
        );

        $siswa = Siswa::where('nisn', $validated['nisn'])
            ->where('tanggal_lahir', $validated['tgl_lahir'])
            ->where('tempat_lahir', Str::lower($validated['tempat_lahir']))
            ->first();
        if (empty($siswa)) {
            session()->flash('errorMessage', 'Data Tidak Ditemukan');
            return;
        }
        session([
            'authenticated_parent' => $siswa->id,
            'parent_session_expiry' => now()->addMinutes(10), // waktu kedaluwarsa 10 menit
        ]);
        session()->flash('errorMessage', $siswa['nama']);
    }
}
