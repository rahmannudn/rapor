<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class NilaiSumatifPerkelasPDFController extends Controller
{
    public Kelas $kelas;

    public function __invoke() {}
}
