<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\KehadiranBulanan;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Livewire\Component;
use App\Models\WaliKelas;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;

class Form extends Component
{
    public $tahunAjaranAktif;
    public $siswaData;
    public $selectedBulan;
    public $jumlahHariEfektif;
    public $kehadiranBulananId;

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

        $daftarBulan = [];
        $tahunAjaran = TahunAjaran::find($this->tahunAjaranAktif);
        if ($tahunAjaran['semester'] === "ganjil") {
            $daftarBulan = [
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
        }
        if ($tahunAjaran['semester'] === "genap") {
            $daftarBulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
            ];
        }

        return view('livewire.absensi.form', ['namaKelas' => $namaKelas, 'daftarBulan' => $daftarBulan]);
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->waliKelasId = WaliKelas::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('user_id', Auth::id())
            ->select('wali_kelas.user_id')
            ->first()?->user_id;
    }

    public function updateHari()
    {
        $data = KehadiranBulanan::updateOrCreate(
            [
                'tahun_ajaran_id' => $this->tahunAjaranAktif,
                'bulan' => $this->selectedBulan,
            ],
            [
                'jumlah_hari_efektif' => $this->jumlahHariEfektif ?? 0,
            ]
        );

        if ($data) $this->kehadiranBulananId = $data->id;
    }

    public function getSiswaData()
    {
        $this->jumlahHariEfektif = null;

        $kehadiranBulanan = KehadiranBulanan::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('bulan', $this->selectedBulan)
            ->first();
        $this->jumlahHariEfektif = $kehadiranBulanan->jumlah_hari_efektif ?? null;
        $this->kehadiranBulananId = $kehadiranBulanan->id ?? null;
        $kehadiranBulananId = $this->kehadiranBulananId;
        $this->siswaData = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->leftJoin('absensi', function (JoinClause $q) use ($kehadiranBulananId) {
                $q->on('absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
                    ->where('absensi.kehadiran_bulanan_id', '=', $kehadiranBulananId); // filter bulan spesifik
            })
            ->leftJoin('kehadiran_bulanan', 'kehadiran_bulanan.id', '=', 'absensi.kehadiran_bulanan_id')
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.id',
                'kelas_siswa.id as kelas_siswa_id',
                'absensi.sakit',
                'absensi.izin',
                'absensi.alfa',
                'kehadiran_bulanan.bulan',
                'kehadiran_bulanan.jumlah_hari_efektif',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->toArray();

        if ($this->selectedBulan == "null") $this->siswaData =  null;
    }

    public function update($index, $type)
    {
        $this->authorize('update', [Absensi::class, $this->waliKelasId]);
        $this->updateHari();
        $updatedData = $this->siswaData[$index];

        $hasil = Absensi::updateOrCreate(
            [
                'kelas_siswa_id' => $updatedData['kelas_siswa_id'],
                'kehadiran_bulanan_id' => $this->kehadiranBulananId,
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
