<?php

namespace App\Livewire\Proyek;

use App\Models\Kelas;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use App\Policies\ProyekPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $selectedKelas;

    public $daftarTahunAjaran;
    public $daftarKelas;

    #[On('updateData')]
    public function render()
    {
        $daftarProyek = '';
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');

        // $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->orderBy('created_at', 'DESC')->get();
        // $this->daftarKelas = Kelas::select('nama', 'id')->orderBy('created_at', 'DESC')->get();

        $this->selectedKelas = WaliKelas::where('tahun_ajaran_id', '=', $this->selectedTahunAjaran)
            ->where('user_id', '=', Auth::id())
            ->join('kelas', 'wali_kelas.kelas_id', 'kelas.id')
            ->select('kelas.nama', 'kelas.id as id_kelas')
            ->first()
            ->toArray();

        $daftarProyek = Proyek::query()
            ->search($this->searchQuery)
            ->joinWaliKelas()
            ->joinUsers()
            ->filterKelas($this->selectedKelas['id_kelas'])
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

        return view('livewire.proyek.table', compact('daftarProyek'));
    }
}
