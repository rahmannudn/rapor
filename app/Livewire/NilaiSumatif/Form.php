<?php

namespace App\Livewire\NilaiSumatif;

use App\Models\Rapor;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\NilaiSumatif;
use App\Models\LingkupMateri;
use App\Helpers\FunctionHelper;
use App\Models\DetailGuruMapel;
use App\Models\GuruMapel;
use Livewire\Attributes\Locked;
use App\Models\NilaiSumatifAkhir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

    public $selectedGuru;
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
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
        // if (Gate::allows('isSuperAdmin')) {
        //     // menampilkan kelas yang diajar, menampilkan mata pelajaran yang diajar
        //     $this->daftarGuruMapel = DB::table('users')
        //         ->join('guru_mapel', 'users.id', '=', 'guru_mapel.user_id')
        //         ->where('guru_mapel.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
        //         ->select('users.name as nama_guru', 'guru_mapel.id')
        //         ->distinct()
        //         ->get();
        // }
        $this->selectedGuru = Auth::id();
        $this->waliKelas = WaliKelas::where('wali_kelas.user_id', Auth::id())
            ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->select('id')
            ->first();

        if (Gate::allows('isGuru')) {
            $this->selectedGuru = Auth::id();
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
            ->where('guru_mapel.user_id', '=', $this->selectedGuru)
            ->where('guru_mapel.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
            ->join('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where('kelas.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
            ->select('kelas.id', 'kelas.nama')
            ->distinct()
            ->get();
    }

    public function getMapel()
    {
        if ($this->selectedGuru && $this->selectedKelas) {
            $this->daftarMapel = DB::table('mapel')
                ->join('detail_guru_mapel', function (JoinClause $q) {
                    $q->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                        ->where('detail_guru_mapel.kelas_id', '=', (int)$this->selectedKelas);
                })
                ->join('guru_mapel', 'guru_mapel.id', '=', 'detail_guru_mapel.guru_mapel_id')
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

    public function simpan()
    {
        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('nilaiSumatifIndex');
    }
}
