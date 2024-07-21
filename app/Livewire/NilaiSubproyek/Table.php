<?php

namespace App\Livewire\NilaiSubproyek;

use App\Models\Kelas;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\NilaiProyek;
use App\Models\TahunAjaran;
use App\Models\CatatanProyek;
use App\Models\NilaiSubproyek;
use App\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;

class Table extends Component
{
    #[Locked]
    public $waliKelasId;
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;
    public $nilaiData;
    public $proyekData;
    public $kelasInfo;

    public $judul;
    public $namaKelas;
    public $fase;
    public $tahunAjaran;
    public $namaWaliKelas;

    public function render()
    {
        return view('livewire.nilai-subproyek.table');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', NilaiSubproyek::class)) {
            $this->daftarKelas = FunctionHelper::getDaftarKelasHasProyek($this->tahunAjaranAktif);

            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')
                ->orderBy('created_at')
                ->get();
        }

        if (Gate::allows('guru')) {
        }
    }

    public function showForm()
    {
        $this->validate(
            ['selectedKelas' => 'required'],
            ['selectedKelas.required' => 'Kelas field is required.',]
        );
        if (is_null($this->selectedKelas)) return;

        $this->formCreate = true;
    }

    public function getKelasInfo()
    {
        $this->kelasInfo = [];
        $waliKelas = '';

        $waliKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('wali_kelas.kelas_id', $this->selectedKelas)
            ->select('wali_kelas.id')
            ->first();

        $data = null;
        if ($this->selectedKelas && $waliKelas) {
            $data = FunctionHelper::getKelasInfo($waliKelas['id']);
        }

        if ($data) {
            $proyek = Proyek::where('wali_kelas_id', '=', $waliKelas['id'])->select('judul_proyek as judul')->first();
            $this->kelasInfo['judul'] = $proyek['judul'];
            $this->kelasInfo['namaKelas'] = $data['nama_kelas'];
            $this->kelasInfo['fase'] = $data['fase'];
            $this->kelasInfo['tahunAjaran'] = $data['tahun'] . ' - ' . ucfirst($data['semester']);
        }

        if (Gate::allows('superAdminOrKepsek') && $waliKelas) {
            $waliKelasInfo = WaliKelas::where('wali_kelas.id', $waliKelas['id'])
                ->joinUser()
                ->select('users.name as nama_wali', 'wali_kelas.id as wali_kelas_id')
                ->first();
            $this->kelasInfo['namaWaliKelas'] = $waliKelasInfo['nama_wali'];
            $this->kelasInfo['waliKelasId'] = $waliKelasInfo['wali_kelas_id'];
        }
    }

    public function getNilai()
    {
        $this->nilaiData = '';
        $this->proyekData = '';
        $this->getKelasInfo();

        // if ($this->selectedKelas && $this->tahunAjaranAktif) {
        //     $this->proyekData = Proyek::joinWaliKelas()
        //         ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
        //         ->where('wali_kelas.kelas_id', $this->selectedKelas)
        //         ->joinDimensi()
        //         ->joinCapaianFase()
        //         ->select(
        //             'proyek.id',
        //             'proyek.judul_proyek',
        //             'dimensi.deskripsi as dimensi_deskripsi',
        //             'capaian_fase.deskripsi as capaian_fase_deskripsi'
        //         )
        //         ->orderBy('proyek.created_at')
        //         ->get();

        //     dump($this->proyekData);
        // }
    }
}
