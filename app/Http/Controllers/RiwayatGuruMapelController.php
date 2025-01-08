<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use Illuminate\Http\Request;

class RiwayatGuruMapelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = GuruMapel::join('users', 'users.id', 'guru_mapel.user_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'guru_mapel.tahun_ajaran_id')
            ->join('detail_guru_mapel', 'detail_guru_mapel.guru_mapel_id', 'guru_mapel.id')
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->join('kelas', 'kelas.id', 'detail_guru_mapel.kelas_id')
            ->select(
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.semester',
                'tahun_ajaran.tahun',
                'guru_mapel.id as guru_mapel_id',
                'users.name as nama_guru',
                'kelas.id as kelas_id',
                'kelas.nama as nama_kelas',
                'mapel.id as mapel_id',
                'mapel.nama_mapel',
            )
            ->orderBy('tahun_ajaran.id')
            ->orderBy('guru_mapel.id')
            ->orderBy('detail_guru_mapel.id')
            ->orderBy('kelas.nama')
            ->orderBy('mapel.nama_mapel')
            ->get()
            ->toArray();

        $formattedData = $this->formatData($data);

        return view('template-laporan-guru-mapel', ['formattedData' => $formattedData]);
    }

    private function formatData($data)
    {
        $result = [];

        foreach ($data as $item) {
            $tahunAjaranKey = $item['tahun_ajaran_id'];
            $guruMapelKey = $item['guru_mapel_id'];

            // Buat grup tahun ajaran jika belum ada
            if (!isset($result[$tahunAjaranKey])) {
                $result[$tahunAjaranKey] = [
                    'tahun' => $item['tahun'],
                    'semester' => $item['semester'],
                    'guru_mapel' => []
                ];
            }

            // Buat grup guru mapel jika belum ada
            if (!isset($result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey])) {
                $result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey] = [
                    'nama_guru' => $item['nama_guru'],
                    'detail_guru_mapel' => []
                ];
            }

            // Tambahkan detail kelas dan mapel
            $kelasKey = $item['kelas_id'];
            if (!isset($result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey]['detail_guru_mapel'][$kelasKey])) {
                $result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey]['detail_guru_mapel'][$kelasKey] = [
                    'nama_kelas' => $item['nama_kelas'],
                    'data_mapel' => []
                ];
            }

            // Tambahkan mapel ke kelas
            $mapelExists = false;
            foreach ($result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey]['detail_guru_mapel'][$kelasKey]['data_mapel'] as $mapel) {
                if ($mapel['mapel_id'] == $item['mapel_id']) {
                    $mapelExists = true;
                    break;
                }
            }

            if (!$mapelExists) {
                $result[$tahunAjaranKey]['guru_mapel'][$guruMapelKey]['detail_guru_mapel'][$kelasKey]['data_mapel'][] = [
                    'mapel_id' => $item['mapel_id'],
                    'nama_mapel' => $item['nama_mapel']
                ];
            }
        }

        // Ubah grup guru mapel menjadi indexed array untuk mempermudah di view
        foreach ($result as &$tahunAjaran) {
            $tahunAjaran['guru_mapel'] = array_values($tahunAjaran['guru_mapel']);
            foreach ($tahunAjaran['guru_mapel'] as &$guruMapel) {
                $guruMapel['detail_guru_mapel'] = array_values($guruMapel['detail_guru_mapel']);
            }
        }

        return array_values($result);
    }
}
