<?php

namespace App\Livewire\CatatanProyek;

use App\Helpers\FunctionHelper;
use App\Models\CatatanProyek;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Proyek;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class Table extends Component
{
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;
    public $proyekData;
    public $catatanSiswa;

    public function render()
    {
        return view('livewire.catatan-proyek.table');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', CatatanProyek::class)) {
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

    public function getCatatan()
    {
        $this->proyekData = '';
        $this->catatanSiswa = '';
        if ($this->selectedKelas && $this->tahunAjaranAktif) {
            $this->proyekData = Proyek::joinWaliKelas()
                ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
                ->where('wali_kelas.kelas_id', $this->selectedKelas)
                ->select(
                    'proyek.id',
                    'proyek.judul_proyek',
                )
                ->orderBy('proyek.created_at')
                ->get();

            if (count($this->proyekData) >= 1) {
                $catatanData = Siswa::joinKelasSiswa()
                    ->joinWaliKelasByKelasAndTahun($this->selectedKelas, $this->tahunAjaranAktif) //join tabel wali kelas dan filter berdasar kelas dan tahun ajaran
                    ->leftJoinProyek()
                    ->leftJoinCatatanProyek()
                    ->select(
                        'siswa.id as siswa_id',
                        'siswa.nama as nama_siswa',
                        'catatan_proyek.catatan',
                    )
                    ->orderBy('siswa.nama')
                    ->orderBy('proyek.created_at')
                    ->get();

                $groupedData = $catatanData->groupBy('siswa_id');

                // mengconvert collection yang memiliki id siswa yang sama menjadi satu array array dan memasukkan beberapa catatan ke dalam array tersebut
                $this->catatanSiswa = CatatanProyek::convertProyekData($groupedData);
            }
        }
    }
}
