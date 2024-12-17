<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class NilaiSumatifPerkelasPDFController extends Controller
{
    public function __invoke(Request $request, $kelas)
    {
        $kelasId = $kelas;
        $dataSiswa = $request->session()->get('dataSiswa');
        $daftarMapel = $request->session()->get('daftarMapel');

        // $request->session()->forget('dataSiswa');
        // $request->session()->forget('daftarMapel');
    }
}
