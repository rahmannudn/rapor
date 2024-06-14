<?php

namespace App\Livewire\Kepsek;

use App\Models\Kepsek;
use Livewire\Component;

class Table extends Component
{
    public $show = 10;
    public $searchQuery;
    public $tahunAjaranAktif;

    public function render()
    {

        $dataKepsek = Kepsek::search($this->searchQuery)
            ->select(
                'kepsek.id',
                'kepsek.awal_menjabat',
                'kepsek.akhir_menjabat',
                'kepsek.aktif',
                'awal_tahun.tahun as tahun_awal_menjabat',
                'awal_tahun.semester as semester_awal_menjabat',
                'akhir_tahun.tahun as tahun_akhir_menjabat',
                'akhir_tahun.semester as semester_akhir_menjabat',
                'users.name as nama_kepsek',
                'users.email as email_kepsek'
            )
            ->joinUser()
            ->joinAwalJabatan()
            ->joinAkhirJabatan()
            ->orderBy('aktif', 'DESC')
            ->orderBy('kepsek.created_at', 'DESC')
            ->get();

        return view('livewire.kepsek.table', compact('dataKepsek'));
    }
}
