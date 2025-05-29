<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Kepsek;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LaporanAbsensiExportPDF extends Controller
{
    public $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $tahunAjaran, $kelas = null)
    {
        $data = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $tahunAjaran)
            ->when($kelas != null, fn($q) => $q->where('kelas_id', $kelas))
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas_siswa.tahun_ajaran_id')
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', 'kehadiran_bulanan.tahun_ajaran_id', 'kelas_siswa.tahun_ajaran_id')
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
                'kehadiran_bulanan.jumlah_hari_efektif',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
            )
            ->orderBy('kelas.id')
            ->get();

        $formattedAbsensi = $this->formatKehadiranSiswa($data->groupBy('siswa_id'));
        $formattedData['absensi'] = $formattedAbsensi->toArray();
        $formattedData['tahun_ajaran'] = $formattedAbsensi[0]['tahun_ajaran'];
        $kepsek = TahunAjaran::where('tahun_ajaran.id', $tahunAjaran)
            ->join('kepsek', 'tahun_ajaran.kepsek_id', 'kepsek.id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'users.nip')
            ->first();

        $formattedData['kepsek'] = [
            'nama_kepsek' => $kepsek['nama_kepsek'],
            'nip' => $kepsek['nip'],
        ];

        return view('template-laporan-absensi', ['data' => $formattedData]);
    }

    protected function formatKehadiranSiswa(Collection $data)
    {
        return $data->map(function ($items, $siswaId) {
            $siswa = $items->first();
            static $no = 1;

            $rekap = [
                'no' => $no++,
                'nama_siswa' => $siswa['nama_siswa'],
                'nama_kelas' => $siswa['nama_kelas'],
                'tahun_ajaran' => $siswa['tahun'] . ' ' . $siswa['semester'],
                'kehadiran_bulanan' => [],
            ];

            foreach ($items as $item) {
                $alfa = (int) ($item['alfa'] ?? 0);
                $sakit = (int) ($item['sakit'] ?? 0);
                $izin = (int) ($item['izin'] ?? 0);
                $hariEfektif = (int) ($item['jumlah_hari_efektif'] ?? 0);

                $rekap['kehadiran_bulanan'][] = [
                    'bulan' => $this->bulan[$item['bulan'] - 1],
                    'jumlah_hari_efektif' => $hariEfektif,
                    'alfa' => $alfa,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'jumlah_kehadiran' => $hariEfektif - ($alfa + $izin + $sakit),
                ];
            }

            return $rekap;
        })->values();
    }
}
