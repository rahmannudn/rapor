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

    public function mount()
    {
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');

        $this->selectedKelas = WaliKelas::where('tahun_ajaran_id', '=', $this->selectedTahunAjaran)
            ->where('user_id', '=', Auth::id())
            ->join('kelas', 'wali_kelas.kelas_id', 'kelas.id')
            ->select('kelas.nama', 'kelas.id as id_kelas')
            ->first()
            ->toArray();

        $this->daftarTahunAjaran = TahunAjaran::select('tahun_ajaran.id', 'tahun_ajaran.tahun', 'tahun_ajaran.semester')
            ->join('wali_kelas', 'wali_kelas.tahun_ajaran_id', 'tahun_ajaran.id')
            ->where('wali_kelas.user_id', Auth::id())
            ->orderBy('tahun_ajaran.created_at', 'DESC')
            ->get();
    }

    #[On('updateData')]
    public function render()
    {
        $daftarProyek = '';

        $daftarProyek = Proyek::query()
            ->search($this->searchQuery)
            ->joinWaliKelas()
            ->joinKelasByWaliKelas()
            ->joinUsers()
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

    public function updated($item, $data) {}
}
