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
use Livewire\Attributes\On;
use Livewire\WithPagination;


class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;

    public $tahunAjaranAktif;
    // public $siswaData;

    #[Locked]
    public $waliKelasId;
    // public $daftarEkskul;
    // public $ekskul;

    #[On('updateData')]
    public function render()
    {
        // $namaKelas = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
        //     ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.id')
        //     ->where('wali_kelas.user_id', Auth::id())
        //     ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
        //     ->select('kelas.nama')
        //     ->first()?->nama;

        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $siswaData = Siswa::search($this->searchQuery)
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->join('nilai_ekskul', 'nilai_ekskul.kelas_siswa_id', 'kelas_siswa.id')
            ->join('ekskul', 'ekskul.id', 'nilai_ekskul.ekskul_id')
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.nisn',
                'siswa.id',
                'kelas_siswa.id as kelas_siswa_id',
                'nilai_ekskul.ekskul_id',
                'nilai_ekskul.deskripsi',
                'ekskul.nama_ekskul',
            )
            ->orderBy('nilai_ekskul.created_at', 'DESC')
            ->orderBy('siswa.nama', 'ASC')
            ->paginate($this->show);

        return view('livewire.nilai-ekskul.table', ['siswaData' => $siswaData]);
    }

    public function mount() {}
}
