<?php

namespace App\Livewire\Absensi;

use App\Models\Kelas;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use Livewire\WithPagination;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;
use App\Models\KehadiranBulanan;
use Illuminate\Support\Collection;
use App\Exports\LaporanAbsensiExcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Excel;

class Laporan extends Component
{
    use WithPagination;

    public $kehadiranBulananId;
    public $selectedTahunAjaran;
    public $daftarTahunAjaran;
    public $daftarKelas;
    public $selectedKelas;
    public $daftarBulan;
    public $selectedBulan;
    public $show = 10;

    public function render()
    {
        $namaKelas = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.id')
            ->where('wali_kelas.user_id', Auth::id())
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->select('kelas.nama')
            ->first()?->nama;

        $daftarBulan = [];
        $tahunAjaran = TahunAjaran::find($this->selectedTahunAjaran);
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

        $siswaData = FunctionHelper::paginateCollection($this->getSiswaData(), $this->show);
        $rekapKehadiran = $this->hitungTotalKehadiran($siswaData->toArray());
        $siswaPaginated = $this->paginatedSiswa;
        $absensiKelas  = $this->getAbsensiKelas();

        $this->dispatch('render-absensi-chart', data: $rekapKehadiran);
        return view('livewire.absensi.laporan', [
            'namaKelas' => $namaKelas,
            'daftarBulan' => $daftarBulan,
            'siswaData' => $siswaData,
            'rekapKehadiran' => $rekapKehadiran,
            'paginatedSiswa' => $siswaPaginated,
            'absensiKelas' => $absensiKelas,
        ]);
    }

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::all(['id', 'tahun', 'semester']);
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');

        $this->getDaftar();
    }

    public function exportExcel()
    {
        return (new LaporanAbsensiExcel($this->selectedTahunAjaran, $this->selectedKelas))->download('laporan_absensi.xlsx', Excel::XLSX);
    }

    public function getDaftar()
    {
        $this->daftarKelas = Kelas::where('tahun_ajaran_id', $this->selectedTahunAjaran)->select('id', 'nama')->get();
        $dataBulan = KehadiranBulanan::where('tahun_ajaran_id', $this->selectedTahunAjaran)->select('id', 'bulan')->get()?->toArray();
        $dataBulan && $this->formatBulan($dataBulan);
    }

    public function getPaginatedSiswaProperty()
    {
        return KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->when($this->selectedKelas != false, function ($q) {
                $q->where('kelas_siswa.kelas_id', $this->selectedKelas);
            })
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->orderBy('kelas_siswa.kelas_id')
            ->select('siswa.id')
            ->paginate($this->show); // paginasi berdasarkan siswa
    }

    public function getAbsensiKelas()
    {

        $kehadiran = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', function (JoinClause $q) {
                $q->on('kehadiran_bulanan.tahun_ajaran_id', '=', 'kelas_siswa.tahun_ajaran_id');
            })
            ->select(
                'kelas.id as kelas_id',
                'kelas.nama',
                'absensi.id as absensi_id',
                'absensi.alfa',
                'absensi.sakit',
                'absensi.izin',
                'absensi.kehadiran_bulanan_id as kehadiran_id',
                'kehadiran_bulanan.id as bulanan_id',
                'kehadiran_bulanan.jumlah_hari_efektif',
            )
            ->distinct()
            ->orderBy('kelas.id')
            ->get();

        $kehadiran_grouped = $kehadiran->groupBy('kelas_id');
        $rekap_absensi = $this->formatAbsensiKelas($kehadiran_grouped);
        return $rekap_absensi;
    }

    public function formatAbsensiKelas($data)
    {
        if (count($data) <= 0) return;
        $results = [];
        foreach ($data as $items) {
            $result = [
                'nama_kelas' => $items->first()->nama,
                'total_alfa' => 0,
                'total_izin' => 0,
                'total_sakit' => 0,
                'total_hari_efektif' => 0,
                'presentase_kehadiran' => 0,
            ];

            foreach ($items as $item) {
                $alfa = (int) ($item['alfa'] ?? 0);
                $sakit = (int) ($item['sakit'] ?? 0);
                $izin = (int) ($item['izin'] ?? 0);
                $hariEfektif = (int) ($item['jumlah_hari_efektif'] ?? 0);

                $result['total_alfa'] += $alfa;
                $result['total_izin'] += $izin;
                $result['total_sakit'] += $sakit;
                $result['total_hari_efektif'] += $hariEfektif;
            }

            $hadir = $result['total_hari_efektif'] - ($result['total_alfa'] + $result['total_izin'] + $result['total_sakit']);
            $presentase = $result['total_hari_efektif'] ? ($hadir / $result['total_hari_efektif'] * 100) : 0;
            $result['presentase_kehadiran'] = round($presentase, 2);
            $results[] = $result;
        }
        return $results;
    }

    public function formatBulan(array $data)
    {
        $result = [];
        $daftarBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        foreach ($data as $v) {
            $result += [$v['bulan'] => $daftarBulan[$v['bulan']]];
        }

        $this->daftarBulan = $result;
    }

    public function updating($field)
    {
        if (in_array($field, ['selectedBulan', 'selectedKelas', 'selectedTahunAjaran', 'show'])) {
            $this->resetPage();
        }
    }

    public function getSiswaData()
    {
        $siswaPaginate = $this->paginatedSiswa;

        $siswaIds = $siswaPaginate->pluck('id');
        $siswa =  KelasSiswa::whereIn('kelas_siswa.siswa_id', $siswaIds)
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', 'kehadiran_bulanan.tahun_ajaran_id', 'kelas_siswa.tahun_ajaran_id')
            ->when($this->selectedBulan != false, function ($q) {
                $q->where('kehadiran_bulanan.bulan', (int) $this->selectedBulan);
            })
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama as nama_siswa',
                'kelas.nama as nama_kelas',
                'absensi.id as absensi_id',
                'absensi.alfa',
                'absensi.sakit',
                'absensi.izin',
                'kehadiran_bulanan.id as kehadiran_bulanan_id',
                'kehadiran_bulanan.bulan',
                'kehadiran_bulanan.jumlah_hari_efektif'
            )
            ->orderBy('kelas.id')
            ->get();

        $groupedSiswa = $siswa->groupBy('siswa_id');
        return $this->formatKehadiranSiswa($groupedSiswa);
    }

    public function formatKehadiranSiswa(Collection $data)
    {
        // Kalau data masih nested array (bukan keyed groupBy), kita harus ubah dulu jadi bentuk keyed groupBy manual
        $flattened = $data->flatten(1); // Biar kita bisa groupBy
        $grouped = $flattened->groupBy('siswa_id');

        return $grouped->map(function ($items, $siswaId) {
            $siswa = $items->first();

            $rekap = [
                'siswa_id' => $siswa['siswa_id'],
                'nama_siswa' => $siswa['nama_siswa'],
                'nama_kelas' => $siswa['nama_kelas'],
                'total_alfa' => 0,
                'total_sakit' => 0,
                'total_izin' => 0,
                'total_hari_efektif' => 0,
                'kehadiran' => [],
                'presentase_kehadiran' => 0,
            ];

            foreach ($items as $item) {
                $alfa = (int) ($item['alfa'] ?? 0);
                $sakit = (int) ($item['sakit'] ?? 0);
                $izin = (int) ($item['izin'] ?? 0);
                $hariEfektif = (int) ($item['jumlah_hari_efektif'] ?? 0);

                $rekap['total_alfa'] += $alfa;
                $rekap['total_sakit'] += $sakit;
                $rekap['total_izin'] += $izin;
                $rekap['total_hari_efektif'] += $hariEfektif;

                $rekap['kehadiran'][] = [
                    'kehadiran_bulanan_id' => $item['kehadiran_bulanan_id'],
                    'bulan' => $item['bulan'],
                    'jumlah_hari_efektif' => $hariEfektif,
                    'alfa' => $alfa,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'absensi_id' => $item['absensi_id'] ?? null,
                ];
            }
            $hadir = $rekap['total_hari_efektif'] - ($rekap['total_alfa'] + $rekap['total_sakit'] + $rekap['total_izin']);
            $presentase = $rekap['total_hari_efektif'] ? ($hadir / $rekap['total_hari_efektif']) * 100 : 0;
            $rekap['presentase_kehadiran'] = round($presentase, 2);
            if ($rekap['total_hari_efektif'] <= 0) $rekap['presentase_kehadiran'] = 0;
            return $rekap;
        })->values(); // values() supaya reset key-nya (jadi numerik index)
    }

    public function hitungTotalKehadiran(array $rekapSiswa)
    {
        $total = [
            'jumlah_kehadiran' => 0,
            'jumlah_alfa' => 0,
            'jumlah_sakit' => 0,
            'jumlah_izin' => 0,
        ];

        foreach ($rekapSiswa['data'] as $siswa) {
            $hadir = $siswa['total_hari_efektif'] - ($siswa['total_alfa'] + $siswa['total_sakit'] + $siswa['total_izin']);

            $total['jumlah_kehadiran'] += max(0, $hadir); // pastikan tidak negatif
            $total['jumlah_alfa'] += $siswa['total_alfa'];
            $total['jumlah_sakit'] += $siswa['total_sakit'];
            $total['jumlah_izin'] += $siswa['total_izin'];
        }

        return $total;
    }
}
