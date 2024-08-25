<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;

class Form extends Component
{
    public $tahunAjaranAktif;
    public $siswaData;

    #[Locked]
    public $waliKelasId;

    public function render()
    {
        $namaKelas = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.id')
            ->where('wali_kelas.user_id', Auth::id())
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->select('kelas.nama')
            ->first()?->nama;

        return view('livewire.absensi.form', ['namaKelas' => $namaKelas]);
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->waliKelasId = WaliKelas::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('user_id', Auth::id())
            ->select('wali_kelas.user_id')
            ->first()?->user_id;

        $this->siswaData = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.id',
                'kelas_siswa.id as kelas_siswa_id',
                'absensi.sakit',
                'absensi.izin',
                'absensi.alfa'
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get()->toArray();
    }

    public function update($index, $type)
    {
        $this->authorize('update', [Absensi::class, $this->waliKelasId]);
        $updatedData = $this->siswaData[$index];

        $hasil = Absensi::updateOrCreate(
            [
                'kelas_siswa_id' => $updatedData['kelas_siswa_id'],
            ],
            [
                $type => $updatedData[$type]
            ],
        );
    }

    public function simpan()
    {
        session()->flash('success', 'Data Berhasil Diubah');
        redirect()->route('absensiIndex');
    }
}
