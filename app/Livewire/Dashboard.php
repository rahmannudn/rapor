<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Ekskul;
use App\Models\Kepsek;
use App\Models\Sekolah;
use Livewire\Component;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $jumlahPengguna;
    public $jumlahRombel;
    public $jumlahSiswa;
    public $jumlahSiswaPerRombel;
    public $dataSekolah;
    public $kepalaSekolah;
    public $jumlahEkskul;

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function mount()
    {
        $isKepsekAktif = auth()->user()->role == 'kepsek' && Cache::get('kepsekAktif') === Auth::id();
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $this->jumlahRombel = Kelas::count();
        $this->jumlahPengguna = User::count();
        $this->jumlahSiswa = Siswa::count();
        $this->jumlahEkskul = Ekskul::count();
        $this->jumlahSiswaPerRombel = DB::table('kelas')
            ->leftJoin('wali_kelas', function ($join) use ($tahunAjaranAktif) {
                $join->on('wali_kelas.kelas_id', '=', 'kelas.id')
                    ->where('wali_kelas.tahun_ajaran_id', '=', $tahunAjaranAktif);
            })
            ->leftJoin('users', 'users.id', '=', 'wali_kelas.user_id')
            ->leftJoin('kelas_siswa', function ($join) use ($tahunAjaranAktif) {
                $join->on('kelas_siswa.kelas_id', '=', 'kelas.id')
                    ->where('kelas_siswa.tahun_ajaran_id', '=', $tahunAjaranAktif);
            })
            ->select(
                'kelas.nama as nama_kelas',
                'kelas.fase',
                'users.name as nama_wali_kelas',
                DB::raw('COUNT(kelas_siswa.siswa_id) as jumlah_siswa')
            )
            ->groupBy('kelas.id', 'users.name')
            ->orderBy('kelas.nama')
            ->get();

        $this->kepalaSekolah = TahunAjaran::where('tahun_ajaran.id', $tahunAjaranAktif)
            ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek')
            ->first();

        $this->dataSekolah = Sekolah::find(1);
    }
}
