<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NilaiSumatifExportController extends Controller
{
    public function cetak_permapel(Request $request)
    {
        $result = $request->session()->get('result');
        $request->session()->forget('result');
        return view('template-laporan-nilai-sumatif', ['result' => $result]);
    }
}
