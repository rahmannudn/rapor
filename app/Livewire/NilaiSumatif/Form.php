<?php

namespace App\Livewire\NilaiSumatif;

use App\Models\Kelas;
use App\Models\Rapor;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\NilaiSumatif;
use Maatwebsite\Excel\Excel;
use App\Models\LingkupMateri;
use App\Helpers\FunctionHelper;
use App\Models\DetailGuruMapel;
use function PHPSTORM_META\map;
use Livewire\Attributes\Locked;
use App\Models\NilaiSumatifAkhir;
use Illuminate\Support\Facades\DB;
use App\Exports\NilaiSumatifExport;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Query\JoinClause;

class Form extends Component
{
    public $daftarGuruMapel;
    public $daftarKelas;
    public $daftarMapel;
    public $formCreate;

    #[Locked]
    public $waliKelas;

    public $tahunAjaranAktif;

    public $selectedGuruMapel;
    public $selectedKelas;
    public $selectedDetailGuruMapel;
    public $showForm;
    public $daftarLingkup;
    public $nilaiData = [];

    #[Locked]
    public $guruMapel;

    public function render()
    {
        return view('livewire.nilai-sumatif.form');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        // if (Gate::allows('isSuperAdmin')) {
        //     // menampilkan kelas yang diajar, menampilkan mata pelajaran yang diajar
        //     $this->daftarGuruMapel = DB::table('users')
        //         ->join('guru_mapel', 'users.id', '=', 'guru_mapel.user_id')
        //         ->where('guru_mapel.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
        //         ->select('users.name as nama_guru', 'guru_mapel.id')
        //         ->distinct()
        //         ->get();
        // }
        $this->waliKelas = WaliKelas::where('wali_kelas.user_id', Auth::id())
            ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->select('id')
            ->first();
        $this->selectedGuruMapel = GuruMapel::where('tahun_ajaran_id', '=', $this->tahunAjaranAktif)->where('user_id', '=', Auth::id())->select('id')->first()['id'];

        if (Gate::allows('isGuru')) {
            $this->getKelas();
        }
    }

    public function getKelas()
    {
        $this->daftarKelas = '';
        $this->daftarMapel = '';
        $this->selectedDetailGuruMapel = '';
        $this->selectedKelas = '';

        $this->daftarKelas = DB::table('detail_guru_mapel')
            ->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
            ->where('guru_mapel.id', '=', $this->selectedGuruMapel)
            ->join('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where('kelas.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
            ->select('kelas.id', 'kelas.nama')
            ->distinct()
            ->get();
    }

    public function getMapel()
    {
        if ($this->selectedGuruMapel && $this->selectedKelas) {
            $this->daftarMapel = DB::table('detail_guru_mapel')
                ->where('detail_guru_mapel.kelas_id', '=', (int)$this->selectedKelas)
                ->where('detail_guru_mapel.guru_mapel_id', '=', $this->selectedGuruMapel)
                ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
                ->select('mapel.nama_mapel', 'detail_guru_mapel.id as detail_guru_mapel_id')
                ->get();
        }
    }

    public function showTable()
    {
        $this->guruMapel = '';

        $validated = $this->validate(
            [
                'selectedKelas' => 'required',
                'selectedDetailGuruMapel' => 'required',
            ],
            [
                'selectedKelas.required' => 'Kelas field is required.',
                'selectedDetailGuruMapel.required' => 'Mapel field is required.',
            ]
        );
        $this->showForm = true;

        $this->guruMapel = DetailGuruMapel::where('detail_guru_mapel.id', $this->selectedDetailGuruMapel)
            ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
            ->select('guru_mapel.user_id')
            ->first()
            ->toArray();

        $this->daftarLingkup = LingkupMateri::where('detail_guru_mapel_id', '=', $validated['selectedDetailGuruMapel'])->select('deskripsi', 'id')->orderBy('created_at')->get();

        $nilai = Siswa::joinKelasSiswa()
            ->where('kelas_siswa.kelas_id', $this->selectedKelas)
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('detail_guru_mapel', function (JoinClause $q) {
                $q->on('detail_guru_mapel.kelas_id', '=', 'kelas_siswa.kelas_id')
                    ->where('detail_guru_mapel.id', '=', $this->selectedDetailGuruMapel);
            })
            ->leftJoin('lingkup_materi', 'lingkup_materi.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
            ->leftJoin('nilai_sumatif', function (JoinClause $q) {
                $q->on('nilai_sumatif.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
                    ->on('nilai_sumatif.kelas_siswa_id', '=', 'kelas_siswa.id')
                    ->on('nilai_sumatif.lingkup_materi_id', '=', 'lingkup_materi.id');
            })
            ->leftJoin('nilai_sumatif_akhir', function (JoinClause $q) {
                $q->on('nilai_sumatif_akhir.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
                    ->on('nilai_sumatif_akhir.kelas_siswa_id', '=', 'kelas_siswa.id');
            })
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'lingkup_materi.id as lingkup_materi_id',
                'nilai_sumatif.nilai as nilai_sumatif',
                'nilai_sumatif_akhir.nilai_tes as nilai_tes',
                'nilai_sumatif_akhir.id as nilai_tes_id',
                'nilai_sumatif_akhir.nilai_nontes as nilai_nontes',
                'kelas_siswa.id as id_kelas_siswa'
            )
            ->orderBy('siswa.nama', 'ASC')
            ->orderBy('lingkup_materi.created_at')
            ->get();

        $groupedData = $nilai->groupBy('id_siswa');

        $results = [];

        foreach ($groupedData as $siswaId => $records) {
            $siswa = [
                'siswa_id' => $siswaId,
                'nama_siswa' => $records->first()->nama_siswa,
            ];

            $nilai = [];
            foreach ($records as $index => $record) {
                $nilai[$index] = [
                    'nilai_sumatif' => $record->nilai_sumatif,
                    'lingkup_materi_id' => $record->lingkup_materi_id
                ];
            }
            $siswa['nilai'] = $nilai;
            $siswa['kelas_siswa_id'] = $record->id_kelas_siswa;
            $siswa['nilai_sumatif_akhir'] = [
                'nilai_tes' => $record->nilai_tes,
                'nilai_nontes' => $record->nilai_nontes,
            ];
            $results[] = $siswa;
        }
        $this->nilaiData = $results;
    }

    public function update($dataIndex, $nilaiIndex)
    {
        $user_id = $this->guruMapel['user_id'];
        $this->authorize('update', [NilaiSumatif::class, $user_id]);

        // mencari array sesuai index nilai yang berubah
        $data = $this->nilaiData[$dataIndex];

        // mengambil data siswa yang berubah        
        if ($nilaiIndex === 'nilai_tes' || $nilaiIndex === 'nilai_nontes') {
            $hasilNilai = NilaiSumatifAkhir::updateOrCreate([
                'detail_guru_mapel_id' => $this->selectedDetailGuruMapel,
                'kelas_siswa_id' => $data['kelas_siswa_id'],
            ], [
                $nilaiIndex => $data['nilai_sumatif_akhir'][$nilaiIndex],
            ]);
        } else {
            $hasilNilai = NilaiSumatif::updateOrCreate([
                'detail_guru_mapel_id' => $this->selectedDetailGuruMapel,
                'kelas_siswa_id' => $data['kelas_siswa_id'],
                'lingkup_materi_id' => $data['nilai'][$nilaiIndex]['lingkup_materi_id']
            ], [
                'nilai' => $data['nilai'][$nilaiIndex]['nilai_sumatif'],
            ]);
        }
    }

    public function updateTotalNilai($dataIndex)
    {
        $totalNilai = 0;
        foreach ($this->nilaiData[$dataIndex]['nilai'] as $item) {
            $totalNilai += (int)$item['nilai_sumatif'];
        }
        $totalNilai += (int)$this->nilaiData[$dataIndex]['nilai_sumatif_akhir']['nilai_tes'];
        $totalNilai += (int)$this->nilaiData[$dataIndex]['nilai_sumatif_akhir']['nilai_nontes'];

        $this->nilaiData['total_nilai'] = $totalNilai;
    }

    public function exportExcel()
    {
        $nilaiData = $this->getRataNilaiSiswa(daftarLingkup: true);

        return (new NilaiSumatifExport($nilaiData, $this->daftarLingkup->toArray()))->download('nilai_sumatif.xlsx', Excel::XLSX);
    }

    public function exportPDF()
    {
        $nilaiData = [];
        $nilaiData['siswa'] = $this->getRataNilaiSiswa();

        $rataNilaiPermapel = 0;
        $totalNilaiPermapel = 0;
        $jumlahNilai = 0;
        $nilaiTerendah = (int)$nilaiData['siswa'][0]['nilai'][0]['nilai_sumatif'];
        $nilaiTertinggi = (int)$nilaiData['siswa'][0]['nilai'][0]['nilai_sumatif'];
        $dataMapel = DetailGuruMapel::where('detail_guru_mapel.id', $this->tahunAjaranAktif)
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', 'guru_mapel.id')
            ->join('users', 'users.id', 'guru_mapel.user_id')
            ->select('users.name as nama_guru', 'mapel.nama_mapel')
            ->first();
        $dataKelas = Kelas::where('id', $this->selectedKelas)->first()->value('nama');
        $dataTahun = TahunAjaran::where('id', $this->tahunAjaranAktif)->select('tahun', 'semester')->first();

        foreach ($nilaiData['siswa'] as $i => $data) {
            foreach ($data['nilai'] as $nilai) {
                $totalNilaiPermapel += (int)$nilai['nilai_sumatif'];

                if ($nilaiTerendah >= $nilai['nilai_sumatif']) $nilaiTerendah = $nilai['nilai_sumatif'];
                if ($nilaiTertinggi <= $nilai['nilai_sumatif']) $nilaiTertinggi = $nilai['nilai_sumatif'];

                $jumlahNilai++;
            }

            // loop terakhir
            if (end($nilaiData['siswa']) == $data) {
                $rataNilaiPermapel = $totalNilaiPermapel / $jumlahNilai;
            }
        }

        $nilaiData['rata_nilai_permapel'] = $rataNilaiPermapel;
        $nilaiData['nilai_tertinggi'] = $nilaiTertinggi;
        $nilaiData['nilai_terendah'] = $nilaiTerendah;
        $nilaiData['nama_mapel'] = $dataMapel['nama_mapel'] ?? '';
        $nilaiData['nama_guru'] = $dataMapel['nama_guru'] ?? '';
        $nilaiData['nama_kelas'] = $dataKelas ?? '';
        $nilaiData['tahun'] = $dataTahun['tahun'] ?? '';
        $nilaiData['semester'] = $dataTahun['semester'] ?? '';

        session()->put('result', $nilaiData);

        $this->dispatch('dataProcessed', url: route('cetak_sumatif_permapel'));
    }

    public function getRataNilaiSiswa($daftarLingkup = null)
    {
        if (!empty($this->nilaiData)) {
            $nilaiData = $this->nilaiData;
            foreach ($nilaiData as &$data) {
                $data['rata_nilai'] = 0;
                $totalNilai = 0;
                $jumlahNilai = 0; // menampung jumlah nilai sumatif yang tidak bernilai 0

                // loop nilai sumatif
                foreach ($data['nilai'] as &$sumatif) {
                    if (empty($sumatif['nilai_sumatif'])) $sumatif['nilai_sumatif'] = 0;
                    $totalNilai += $sumatif['nilai_sumatif'];

                    // jika nilai sumatif 0 jumlah nilai tidak ditambahkan
                    $sumatif['nilai_sumatif'] !== 0 ? $jumlahNilai++ : '';
                }

                $nilaiTes = $data['nilai_sumatif_akhir']['nilai_tes'] ?? 0;
                if ($nilaiTes !== 0) {
                    $totalNilai += $nilaiTes;
                    $jumlahNilai++;
                }

                $nilaiNontes = $data['nilai_sumatif_akhir']['nilai_nontes'] ?? 0;
                if ($nilaiNontes !== 0) {
                    $totalNilai += $nilaiNontes;
                    $jumlahNilai++;
                }

                // hitung rata-rata
                if (!empty($totalNilai) && !empty($jumlahNilai)) $data['rata_nilai'] = $totalNilai / $jumlahNilai;

                // menghapus siswa_id dari array
                unset($data['siswa_id']);

                if ($daftarLingkup === true)
                    $data['daftar_lingkup'] = $this->daftarLingkup;
            }
            return $nilaiData;
        }
    }

    public function simpan()
    {
        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('nilaiSumatifIndex');
    }
}
