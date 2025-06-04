<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RiwayatWaliKelasController extends Controller
{
    public function __invoke(?TahunAjaran $tahunAjaran)
    {
        $tahunAjaran = $tahunAjaran->toArray();
        $data = DB::table('kelas')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas.tahun_ajaran_id')
            ->when($tahunAjaran, function ($q) use ($tahunAjaran) {
                return $q->where('tahun_ajaran.id', $tahunAjaran['id']);
            })
            ->join('wali_kelas', function (JoinClause $q) {
                $q->on('wali_kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
                    ->on('wali_kelas.kelas_id', '=', 'kelas.id');
            })
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->select(
                'tahun_ajaran.semester',
                'tahun_ajaran.tahun',
                'kelas.nama as nama_kelas',
                'users.name as nama_wali_kelas',
                'tahun_ajaran.id as tahun_ajaran_id'
            )
            ->orderBy('kelas.nama')
            ->get()->toArray();

        $formattedData = $this->formatData($data);

        $tahunAjaran = Cache::get('tahunAjaranAktif');
        $data['data_wali_kelas'] = $formattedData;
        $data['kepsek'] = TahunAjaran::where('tahun_ajaran.id', $tahunAjaran)
            ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'users.nip')
            ->first();

        return view('template-laporan-riwayat-wali', ['data' => $data]);
    }

    private function formatData($data)
    {
        $result = array_reduce($data, function ($carry, $item) {
            $tahunAjaranId = $item->tahun_ajaran_id;

            if (!isset($carry[$tahunAjaranId])) {
                $carry[$tahunAjaranId] = [
                    'semester' => $item->semester,
                    'tahun' => $item->tahun,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'data_kelas' => []
                ];
            }

            $carry[$tahunAjaranId]['data_kelas'][] = [
                'nama_kelas' => $item->nama_kelas,
                'nama_wali_kelas' => $item->nama_wali_kelas
            ];

            return $carry;
        }, []);

        return array_values($result);
    }
}
