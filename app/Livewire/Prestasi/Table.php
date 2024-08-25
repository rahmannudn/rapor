<?php

namespace App\Livewire\Prestasi;

use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;

    public $daftarPrestasi;
    public $tahunAjaranAktif;

    #[On('updateData')]
    public function render()
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $siswaData = Prestasi::search($this->searchQuery)
            ->join('siswa', 'siswa.id', 'prestasi.siswa_id')
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', 'kelas_siswa.tahun_ajaran_id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranAktif)
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select(
                'prestasi.id',
                'prestasi.nama_prestasi',
                'prestasi.tgl_prestasi',
                'prestasi.penyelenggara',
                'prestasi.deskripsi',
                'prestasi.bukti',
                'prestasi.nilai_prestasi',
                'siswa.nama as nama_siswa',
                'siswa.id as id_siswa',
                'kelas.nama as nama_kelas',
            )
            ->orderBy('prestasi.created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.prestasi.table', compact('siswaData'));
    }
}
