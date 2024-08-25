<?php

namespace App\Livewire\NilaiEkskul;

use App\Models\Siswa;
use App\Models\Ekskul;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Form extends Component
{
    public $tahunAjaranAktif;
    public $siswaData;

    #[Locked]
    public $waliKelasId;

    public $daftarEkskul;

    public $eskuls;

    public function render()
    {
        $namaKelas = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.id')
            ->where('wali_kelas.user_id', Auth::id())
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->select('kelas.nama')
            ->first()?->nama;

        return view('livewire.nilai-ekskul.form', ['namaKelas' => $namaKelas]);
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $this->daftarEkskul = Ekskul::select('id', 'nama_ekskul')
            ->get()
            ->toArray();

        $this->waliKelasId = WaliKelas::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('user_id', Auth::id())
            ->select('wali_kelas.user_id')
            ->first()?->user_id;

        $this->siswaData = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->leftJoin('nilai_ekskul', 'nilai_ekskul.kelas_siswa_id', 'kelas_siswa.id')
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.id',
                'kelas_siswa.id as kelas_siswa_id',
                'nilai_ekskul.ekskul_id',
                'nilai_ekskul.deskripsi',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->toArray();
    }
}
