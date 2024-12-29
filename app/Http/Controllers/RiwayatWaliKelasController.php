<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatWaliKelasController extends Controller
{
    public function __invoke()
    {
        $data = DB::table('kelas')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas.tahun_ajaran_id')
            ->join('wali_kelas', function (JoinClause $q) {
                $q->on('wali_kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
                    ->on('wali_kelas.kelas_id', '=', 'kelas.id');
            })
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->select(
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.semester',
                'tahun_ajaran.tahun',
                DB::raw('GROUP_CONCAT(DISTINCT kelas.nama ORDER BY kelas.nama ASC SEPARATOR ", ") as nama_kelas'),
                DB::raw('GROUP_CONCAT(DISTINCT users.name ORDER BY users.name ASC SEPARATOR ", ") as nama_wali_kelas')
            )
            ->groupBy('tahun_ajaran.id', 'tahun_ajaran.semester', 'tahun_ajaran.tahun')
            ->orderBy('tahun_ajaran.id')
            ->get();

        $processedData = $data->map(function ($item) {
            $item->nama_kelas = explode(', ', $item->nama_kelas);
            $item->nama_wali_kelas = explode(', ', $item->nama_wali_kelas);
            return $item;
        });
    }
}
