<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Proyek;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\Sekolah;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class RaporP5Controller extends Controller
{
    public $tahunAjaranAktif;

    public function __construct(Siswa $siswa, $kelasSiswa = null)
    {
        if (!empty($kelasSiswa)) {
            $this->tahunAjaranAktif = $kelasSiswa::where('id', $kelasSiswa)->first()->value('tahun_ajaran_id');
        }


        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
    }

    public function cetak(Siswa $siswa, $kelasSiswa)
    {
        try {
            // $waliKelas = WaliKelas::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            //     ->where('user_id', Auth::id())
            //     ->select('id', 'user_id')
            //     ->first();

            if (Gate::allows('isWaliKelas') && empty($kelasSiswa)) {
                $waliKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
                    ->where('wali_kelas.user_id', Auth::id())
                    ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                    ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas.id')
                    ->join('users', 'users.id', 'wali_kelas.user_id')
                    ->select(
                        'wali_kelas.id',
                        'wali_kelas.user_id',
                        'kelas.id as kelas_id',
                        'kelas.nama as nama_kelas',
                        'kelas.fase',
                        'users.name as nama_wali',
                        'users.nip as nip_wali'
                    )
                    ->first();
            }
            if (!empty($kelasSiswa)) {
                $waliKelas = KelasSiswa::where('kelas_siswa.id', $kelasSiswa)
                    ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                    ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas.id')
                    ->join('users', 'users.id', 'wali_kelas.user_id')
                    ->select(
                        'wali_kelas.id',
                        'wali_kelas.user_id',
                        'kelas.id as kelas_id',
                        'kelas.nama as nama_kelas',
                        'kelas.fase',
                        'users.name as nama_wali',
                        'users.nip as nip_wali'
                    )
                    ->first();
            }

            $dataSekolah = Sekolah::where('id', 1)->select('nama_sekolah', 'alamat_sekolah', 'logo_sekolah')->first();

            $dataTahunAjaran = TahunAjaran::where('id', $this->tahunAjaranAktif)->select('tahun')->first();

            $dataKepsek = TahunAjaran::where('tahun_ajaran.id', $this->tahunAjaranAktif)
                ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
                ->join('users', 'users.id', 'kepsek.user_id')
                ->select('users.name as nama_kepsek', 'users.nip as nip_kepsek')
                ->first();

            $proyek = Proyek::where('proyek.wali_kelas_id', $waliKelas['id'])
                ->join('wali_kelas', 'wali_kelas.id', '=', 'proyek.wali_kelas_id')
                ->join('kelas_siswa', function (JoinClause $q) use ($siswa) {
                    $q->on('kelas_siswa.kelas_id', '=', 'wali_kelas.kelas_id')
                        ->where('kelas_siswa.siswa_id', '=', $siswa->id);
                })
                ->join('subproyek', 'subproyek.proyek_id', 'proyek.id')
                ->join('capaian_fase', 'capaian_fase.id', 'subproyek.capaian_fase_id')
                ->join('subelemen', 'capaian_fase.subelemen_id', 'subelemen.id')
                ->join('elemen', 'subelemen.elemen_id', 'elemen.id')
                ->join('dimensi', 'elemen.dimensi_id', 'dimensi.id')
                ->join('nilai_subproyek', function (JoinClause $q) {
                    $q->on('nilai_subproyek.kelas_siswa_id', '=', 'kelas_siswa.id')
                        ->on('nilai_subproyek.subproyek_id', '=', 'subproyek.id');
                })
                ->leftJoin('catatan_proyek', function (JoinClause $q) use ($siswa) {
                    $q->on('catatan_proyek.proyek_id', 'proyek.id')
                        ->where('catatan_proyek.siswa_id', '=', $siswa->id);
                })
                ->select(
                    'proyek.deskripsi as proyek_deskripsi',
                    'proyek.judul_proyek',
                    'capaian_fase.deskripsi as capaian_fase_deskripsi',
                    'subelemen.deskripsi as subelemen_deskripsi',
                    'dimensi.deskripsi as dimensi_deskripsi',
                    'subproyek.id as subproyek_id',
                    'nilai_subproyek.nilai',
                    'nilai_subproyek.id as nilai_subproyek_id',
                    'catatan_proyek.catatan as catatan_proyek'
                )
                ->get()
                ->toArray();
            if (empty($proyek))  return redirect()->back()->with('gagal', 'Nilai Proyek tidak boleh kosong.');

            $grouped_data = [];
            foreach ($proyek as $item) {
                $judul_proyek = $item['judul_proyek'];

                if (!isset($grouped_data[$judul_proyek])) {
                    $grouped_data[$judul_proyek] = [
                        'proyek_deskripsi' => $item['proyek_deskripsi'],
                        'judul_proyek' => $judul_proyek,
                        'catatan' => $item['catatan_proyek'],
                        'subproyek' => []
                    ];
                }

                $grouped_data[$judul_proyek]['subproyek'][] = [
                    'capaian_fase_deskripsi' => $item['capaian_fase_deskripsi'],
                    'subelemen_deskripsi' => $item['subelemen_deskripsi'],
                    'dimensi_deskripsi' => $item['dimensi_deskripsi'],
                    'subproyek_id' => $item['subproyek_id'],
                    'nilai' => $item['nilai'],
                    'nilai_subproyek_id' => $item['nilai_subproyek_id'],
                    'catatan_proyek' => $item['catatan_proyek']
                ];
            }

            $result['proyek'] = $grouped_data;
            $result['nama_kelas'] = $waliKelas['nama_kelas'] ?? null;
            $result['fase'] = $waliKelas['fase'] ?? null;
            $result['nama_wali'] = $waliKelas['nama_wali'];
            $result['nip_wali'] = $waliKelas['nip_wali'];
            $result['nama_kepsek'] = $dataKepsek['nama_kepsek'];
            $result['nip_kepsek'] = $dataKepsek['nip_kepsek'];
            $result['nama_sekolah'] = $dataSekolah['nama_sekolah'];
            $result['alamat_sekolah'] = $dataSekolah['alamat_sekolah'];
            $result['logo'] = $dataSekolah['logo_sekolah'];
            $result['tahun_ajaran'] = $dataTahunAjaran['tahun'];
            $result['nama_siswa'] = $siswa->nama;
            $result['nisn'] = $siswa->nisn;
            $result['tgl_rapor'] = $siswa->tgl_rapor;

            return view('template-raporp5', ['result' => $result]);
        } catch (Exception $e) {
            return Redirect::back()->with('gagal', $e ?? "Data tidak ditemukan");
        }
    }
}
