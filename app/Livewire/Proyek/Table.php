<?php

namespace App\Livewire\Proyek;

use App\Models\Kelas;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Gate;

class Table extends Component
{
    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $selectedKelas;

    public $daftarTahunAjaran;
    public $daftarKelas;

    public function render()
    {
        $daftarProyek = '';
        $this->selectedTahunAjaran = TahunAjaran::where('aktif', 1)->select('id')->first()['id'];

        if (Gate::allows('isSuperAdmin')) {
            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->orderBy('created_at', 'DESC')->get();
            $this->daftarKelas = Kelas::select('nama', 'id')->orderBy('created_at', 'DESC')->get();
            $daftarProyek = Proyek::query()
                ->search($this->searchQuery)
                ->joinWaliKelas()
                ->joinUsers()
                ->filterKelas($this->selectedKelas)
                ->filterTahunAjaran($this->selectedTahunAjaran)
                ->select(
                    'proyek.id',
                    'proyek.judul_proyek',
                    'proyek.deskripsi',
                    'kelas.nama as nama_kelas',
                    'users.name as nama_guru',
                    'tahun_ajaran.tahun',
                    'tahun_ajaran.semester'
                )
                ->orderBy('proyek.created_at', 'DESC')
                ->paginate($this->show);
        }
        return view('livewire.proyek.table', compact('daftarProyek'));
    }
}
