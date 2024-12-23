<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class LaporanEkskulExportPDF extends Controller
{
    public TahunAjaran $tahunAjaran;
    public Kelas $kelas;

    public function __invoke(TahunAjaran $tahunAjaran, ?Kelas $kelas)
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->kelas = $kelas;
    }
}
