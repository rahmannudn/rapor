<?php

namespace App\Livewire\Absensi;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\KelasSiswa;
use App\Models\KehadiranBulanan;
use App\Exports\LaporanAbsensiExcel;
use App\Helpers\FunctionHelper;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Excel;

class Laporan extends Component
{
    use WithPagination;

    public $selectedTahunAjaran;
    public $daftarTahunAjaran;
    public $daftarKelas;
    public $selectedKelas;
    public $daftarBulan;
    public $selectedBulan;
    public $show = 10;

    public $absensiKelas;
    public $rekapKehadiran;
    public $namaKelas;

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::all(['id', 'tahun', 'semester']);
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');
        $this->getDaftar();
    }

    public function render()
    {
        $tahunAjaran = TahunAjaran::find($this->selectedTahunAjaran);

        $this->daftarBulan = match ($tahunAjaran->semester) {
            'ganjil' => [7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'],
            'genap' => [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni'],
            default => [],
        };

        $siswaData = $this->getSiswaPagination(); // Sudah sekaligus format
        $this->rekapKehadiran = $this->hitungTotalKehadiran($siswaData->toArray());
        $this->dispatch('absensiKelasUpdated', $this->absensiKelas);
        $this->dispatch('rekap-kehadiran-updated', $this->rekapKehadiran);

        return view('livewire.absensi.laporan', [
            'daftarBulan' => $this->daftarBulan,
            'siswaData' => $siswaData,
            'paginatedSiswa' => $this->paginatedSiswa,
        ]);
    }

    public function updated($field, $value)
    {
        if (in_array($field, ['selectedBulan', 'selectedKelas', 'selectedTahunAjaran', 'show'])) {
            $this->resetPage();
            $this->getDaftar(); // perbarui daftar saat filter berubah
        }
    }

    public function getPaginatedSiswaProperty()
    {
        return KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->when($this->selectedKelas, fn($q) => $q->where('kelas_siswa.kelas_id', $this->selectedKelas))
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->orderBy('kelas_siswa.kelas_id')
            ->select('siswa.id')
            ->paginate($this->show);
    }

    public function getSiswaPagination()
    {
        return FunctionHelper::paginateCollection($this->getSiswaData(), $this->show);
    }

    public function getDaftar()
    {
        $this->daftarKelas = Kelas::where('tahun_ajaran_id', $this->selectedTahunAjaran)->select('id', 'nama')->get();
        $dataBulan = KehadiranBulanan::where('tahun_ajaran_id', $this->selectedTahunAjaran)->select('id', 'bulan')->get()?->toArray();
        if ($dataBulan) $this->formatBulan($dataBulan);
        $this->absensiKelas = $this->getAbsensiKelas();
        $this->dispatch('absensiKelasUpdated', $this->absensiKelas);
    }

    public function getAbsensiKelas()
    {
        $kehadiran = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', fn(JoinClause $q) =>
            $q->on('kehadiran_bulanan.tahun_ajaran_id', '=', 'kelas_siswa.tahun_ajaran_id'))
            ->select(
                'kelas.id as kelas_id',
                'kelas.nama',
                'absensi.alfa',
                'absensi.sakit',
                'absensi.izin',
                'kehadiran_bulanan.jumlah_hari_efektif',
            )
            ->distinct()
            ->orderBy('kelas.id')
            ->get();

        $this->namaKelas = $kehadiran[0]['nama'] ?? null;

        return $this->formatAbsensiKelas($kehadiran->groupBy('kelas_id'));
    }

    public function formatAbsensiKelas($grouped)
    {
        return $grouped->map(function ($items) {
            $data = [
                'nama_kelas' => $items->first()->nama,
                'total_alfa' => 0,
                'total_izin' => 0,
                'total_sakit' => 0,
                'total_hari_efektif' => 0,
                'presentase_kehadiran' => 0,
            ];

            foreach ($items as $item) {
                $data['total_alfa'] += (int) ($item->alfa ?? 0);
                $data['total_izin'] += (int) ($item->izin ?? 0);
                $data['total_sakit'] += (int) ($item->sakit ?? 0);
                $data['total_hari_efektif'] += (int) ($item->jumlah_hari_efektif ?? 0);
            }

            $hadir = $data['total_hari_efektif'] - ($data['total_alfa'] + $data['total_izin'] + $data['total_sakit']);
            $data['presentase_kehadiran'] = $data['total_hari_efektif'] ? round($hadir / $data['total_hari_efektif'] * 100, 2) : 0;

            return $data;
        })->values();
    }

    public function getSiswaData()
    {
        $siswaIds = $this->paginatedSiswa->pluck('id');

        $siswa = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->selectedTahunAjaran)
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', 'kehadiran_bulanan.tahun_ajaran_id', 'kelas_siswa.tahun_ajaran_id')
            ->when($this->selectedBulan, fn($q) =>
            $q->where('kehadiran_bulanan.bulan', (int) $this->selectedBulan))
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select(
                'kelas_siswa.id as kelas_siswa_id',
                'siswa.id as siswa_id',
                'siswa.nama as nama_siswa',
                'kelas.nama as nama_kelas',
                'absensi.alfa',
                'absensi.sakit',
                'absensi.izin',
                'kehadiran_bulanan.bulan',
                'kehadiran_bulanan.jumlah_hari_efektif',
                'kehadiran_bulanan.id as kehadiran_bulanan_id',
                'absensi.id as absensi_id',
            )
            ->orderBy('kelas.id')
            ->get();

        return $this->formatKehadiranSiswa($siswa->groupBy('siswa_id'));
    }

    public function formatKehadiranSiswa(Collection $data)
    {
        return $data->map(function ($items) {
            $siswa = $items->first();

            $rekap = [
                'siswa_id' => $siswa->siswa_id,
                'nama_siswa' => $siswa->nama_siswa,
                'nama_kelas' => $siswa->nama_kelas,
                'total_alfa' => 0,
                'total_sakit' => 0,
                'total_izin' => 0,
                'total_hari_efektif' => 0,
                'kehadiran' => [],
                'presentase_kehadiran' => 0,
            ];

            foreach ($items as $item) {
                $alfa = (int) ($item->alfa ?? 0);
                $sakit = (int) ($item->sakit ?? 0);
                $izin = (int) ($item->izin ?? 0);
                $hariEfektif = (int) ($item->jumlah_hari_efektif ?? 0);

                $rekap['total_alfa'] += $alfa;
                $rekap['total_sakit'] += $sakit;
                $rekap['total_izin'] += $izin;
                $rekap['total_hari_efektif'] += $hariEfektif;

                $rekap['kehadiran'][] = [
                    'bulan' => $item->bulan,
                    'jumlah_hari_efektif' => $hariEfektif,
                    'alfa' => $alfa,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'kehadiran_bulanan_id' => $item->kehadiran_bulanan_id,
                    'absensi_id' => $item->absensi_id,
                ];
            }

            $hadir = $rekap['total_hari_efektif'] - ($rekap['total_alfa'] + $rekap['total_sakit'] + $rekap['total_izin']);
            $rekap['presentase_kehadiran'] = $rekap['total_hari_efektif'] > 0 ? round($hadir / $rekap['total_hari_efektif'] * 100, 2) : 0;

            return $rekap;
        })->values();
    }

    public function hitungTotalKehadiran(array $rekapSiswa)
    {
        $total = [
            'jumlah_kehadiran' => 0,
            'jumlah_alfa' => 0,
            'jumlah_sakit' => 0,
            'jumlah_izin' => 0,
        ];

        foreach ($rekapSiswa['data'] ?? [] as $siswa) {
            $hadir = $siswa['total_hari_efektif'] - ($siswa['total_alfa'] + $siswa['total_sakit'] + $siswa['total_izin']);
            $total['jumlah_kehadiran'] += max(0, $hadir);
            $total['jumlah_alfa'] += $siswa['total_alfa'];
            $total['jumlah_sakit'] += $siswa['total_sakit'];
            $total['jumlah_izin'] += $siswa['total_izin'];
        }

        return $total;
    }

    public function formatBulan(array $data)
    {
        $map = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $this->daftarBulan = collect($data)->mapWithKeys(fn($v) => [$v['bulan'] => $map[$v['bulan']]]);
    }

    public function exportExcel()
    {
        return (new LaporanAbsensiExcel($this->selectedTahunAjaran, $this->selectedKelas))->download('laporan_absensi.xlsx', Excel::XLSX);
    }
}
