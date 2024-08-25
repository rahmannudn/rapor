<?php

namespace App\Livewire\Prestasi;

use App\Models\Prestasi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Detail extends Component
{
    public Prestasi $prestasiData;
    public $namaSiswa;
    public $namaKelas;
    public $namaPrestasi;
    public $tglPrestasi;
    public $penyelenggara;
    public $deskripsi;
    public $bukti;
    public $nilaiPrestasi;

    public function render()
    {
        return view('livewire.prestasi.detail');
    }
    public function mount()
    {
        $tahunAjaran = Cache::get('tahunAjaranAktif');
        $siswa = Siswa::where('siswa.id', $this->prestasiData['siswa_id'])
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaran)
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select('siswa.nama as nama_siswa', 'kelas.nama as nama_kelas')
            ->first();

        $this->namaSiswa = $siswa['nama_siswa'];
        $this->namaKelas = $siswa['nama_kelas'];
        $this->tglPrestasi = Carbon::parse($this->prestasiData['tgl_prestasi'])->translatedFormat('d F Y');
        $this->namaPrestasi = $this->prestasiData['nama_prestasi'];
        $this->penyelenggara = $this->prestasiData['penyelenggara'];
        $this->deskripsi = $this->prestasiData['deskripsi'];
        $this->nilaiPrestasi = $this->prestasiData['nilai_prestasi'];
        $this->bukti = $this->prestasiData['bukti'];
    }
}
