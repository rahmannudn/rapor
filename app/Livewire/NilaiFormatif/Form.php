<?php

namespace App\Livewire\NilaiFormatif;

use App\Models\Rapor;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Helpers\FunctionHelper;
use App\Models\NilaiFormatif;
use Livewire\Attributes\Locked;
use App\Models\TujuanPembelajaran;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\JoinClause;
use Livewire\Attributes\On;

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
    public $daftarTP;
    public $nilaiData = [];

    public function render()
    {
        return view('livewire.nilai-formatif.form');
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
            ->select('id', 'user_id')
            ->first()
            ->toArray();

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

        $this->daftarTP = TujuanPembelajaran::where('detail_guru_mapel_id', $this->selectedDetailGuruMapel)
            ->select('deskripsi')
            ->orderBy('created_at')
            ->get()
            ->toArray();

        $nilai =  Siswa::query()
            ->joinKelasSiswa()
            ->where('kelas_siswa.kelas_id', $this->selectedKelas)
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('detail_guru_mapel', function (JoinClause $q) {
                $q->on('detail_guru_mapel.kelas_id', '=', 'kelas_siswa.kelas_id')
                    ->where('detail_guru_mapel.id', '=', $this->selectedDetailGuruMapel);
            })
            ->leftJoin('tujuan_pembelajaran', 'tujuan_pembelajaran.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
            ->leftJoin('nilai_formatif', function (JoinClause $q) {
                $q->on('nilai_formatif.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
                    ->on('nilai_formatif.kelas_siswa_id', 'kelas_siswa.id')
                    ->on('nilai_formatif.tujuan_pembelajaran_id', 'tujuan_pembelajaran.id');
            })
            ->select(
                'siswa.id as id_siswa',
                'siswa.nama as nama_siswa',
                'nilai_formatif.kktp',
                'nilai_formatif.tampil',
                'tujuan_pembelajaran.deskripsi as tujuan_pembelajaran_deskripsi',
                'tujuan_pembelajaran.id as tujuan_pembelajaran_id',
                'kelas_siswa.id as id_kelas_siswa',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->orderBy('tujuan_pembelajaran.created_at')
            ->get();

        $groupedData = $nilai->groupBy('id_siswa');

        $results = [];

        foreach ($groupedData as $siswaId => $records) {
            $siswa = [
                'siswa_id' => $siswaId,
                'nama_siswa' => $records->first()->nama_siswa,
            ];

            $detail = [];
            foreach ($records as $index => $record) {
                $detail[$index] = [
                    'kktp' => (bool)$record->kktp,
                    'tampil' => (bool)$record->tampil,
                    'tujuan_pembelajaran_deksripsi' => $record->tujuan_pembelajaran_deskripsi,
                    'tujuan_pembelajaran_id' => $record->tujuan_pembelajaran_id
                ];
                $siswa['kelas_siswa_id'] = $record->id_kelas_siswa;
            }
            $siswa['detail'] = $detail;
            $results[] = $siswa;
        }

        $this->dispatch('generateDeskripsi', dataIndex: null, nilaiIndex: null, nilaiData: $results);
    }

    #[On('updateDeskripsi')]
    public function updateDeskripsi($modifiedData)
    {
        $this->nilaiData = json_decode($modifiedData, true);
    }

    public function update($dataIndex, $nilaiIndex, $tipe)
    {
        // mencari array sesuai index nilai yang berubah
        $data = $this->nilaiData[$dataIndex];

        // mencari array sesuai index nilai yang berubah
        $updatedNilai = $data['detail'][$nilaiIndex];

        // memastikan data yang disimpan adalah boolean
        $updatedNilai['kktp'] = (bool)$updatedNilai['kktp'];
        $updatedNilai['tampil'] = (bool)$updatedNilai['tampil'];

        $hasilNilai = NilaiFormatif::updateOrCreate([
            'detail_guru_mapel_id' => $this->selectedDetailGuruMapel,
            'kelas_siswa_id' => $data['kelas_siswa_id'],
            'tujuan_pembelajaran_id' => $updatedNilai['tujuan_pembelajaran_id'],
        ], [
            $tipe => $updatedNilai[$tipe],
        ]);

        $this->dispatch(
            'generateDeskripsi',
            dataIndex: $dataIndex,
            nilaiIndex: $nilaiIndex,
            nilaiData: $this->nilaiData
        );
    }
}
