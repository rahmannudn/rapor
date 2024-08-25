<?php

namespace App\Livewire\Prestasi;

use App\Models\Prestasi;
use App\Models\Siswa;
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
        $siswaData = Prestasi::search($this->searchQuery)
            ->join('siswa', 'siswa.id', 'prestasi.siswa_id')
            ->select(
                'prestasi.id',
                'prestasi.nama_prestasi',
                'prestasi.tgl_prestasi',
                'prestasi.penyelenggara',
                'prestasi.deskripsi',
                'prestasi.bukti',
                'prestasi.nilai_prestasi',
                'siswa.nama as nama_siswa',
                'siswa.id as id_siswa'
            )
            ->orderBy('prestasi.created_at')
            ->paginate($this->show);

        return view('livewire.prestasi.table', compact('siswaData'));
    }
}
