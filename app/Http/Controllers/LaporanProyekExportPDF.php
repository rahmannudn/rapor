<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LaporanProyekExportPDF extends Controller
{
    public function __invoke(Request $request, ?TahunAjaran $tahunAjaran, $query)
    {
        $data = Proyek::query()
            ->joinWaliKelas()
            ->when(Gate::allows('isWaliKelas'), function ($query) {
                $query->where('wali_kelas.user_id', Auth::id());
            })
            ->joinKelasByWaliKelas()
            ->joinUsers()
            ->when(
                $tahunAjaran,
                function ($query) use ($tahunAjaran) {
                    return $query->filterTahunAjaran($tahunAjaran['id']);
                },
                function ($query) {
                    return $query->joinTahunByWaliKelas();
                }
            )
            ->join('subproyek', 'subproyek.proyek_id', 'proyek.id')
            ->join('capaian_fase', 'capaian_fase.id', 'subproyek.capaian_fase_id')
            ->join('subelemen', 'subelemen.id', 'capaian_fase.subelemen_id')
            ->join('elemen', 'elemen.id', 'subelemen.elemen_id')
            ->join('dimensi', 'dimensi.id', 'elemen.dimensi_id')
            ->select(
                'wali_kelas.id as wali_kelas_id',
                'proyek.id as proyek_id',
                'proyek.judul_proyek',
                'proyek.deskripsi as proyek_deskripsi',
                'subproyek.id as subproyek_id',
                'capaian_fase.deskripsi as capaian_fase_deskripsi',
                'subelemen.deskripsi as subelemen_deskripsi',
                'elemen.deskripsi as elemen_deskripsi',
                'dimensi.deskripsi as dimensi_deskripsi',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('proyek.created_at', 'DESC')
            ->orderBy('tahun_ajaran.id')
            ->orderBy('kelas.nama')
            ->get();

        $tahunAjaran = Cache::get('tahunAjaranAktif');
        $formattedData = $this->formatSubproyekData($data);
        $data['data_proyek'] = $formattedData;
        $data['kepsek'] = TahunAjaran::where('tahun_ajaran.id', $tahunAjaran)
            ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'users.nip')
            ->first();

        return view('template-laporan-proyek', ['data' => $data]);
    }

    private function formatSubproyekData($data)
    {
        $formattedData = [];

        foreach ($data as $item) {
            $proyekId = $item['proyek_id'];

            // Jika proyek belum ada di array hasil, tambahkan
            if (!isset($formattedData[$proyekId])) {
                $formattedData[$proyekId] = [
                    "wali_kelas_id" => $item["wali_kelas_id"],
                    "proyek_id" => $item["proyek_id"],
                    "judul_proyek" => $item["judul_proyek"],
                    "proyek_deskripsi" => $item["proyek_deskripsi"],
                    "nama_kelas" => $item["nama_kelas"],
                    "nama_guru" => $item["nama_guru"],
                    "tahun_ajaran_id" => $item["tahun_ajaran_id"],
                    "tahun" => $item["tahun"],
                    "semester" => $item["semester"],
                    "subproyek" => []
                ];
            }

            // Tambahkan data subproyek ke dalam proyek
            $formattedData[$proyekId]["subproyek"][] = [
                "subproyek_id" => $item["subproyek_id"],
                "capaian_fase_deskripsi" => $item["capaian_fase_deskripsi"],
                "subelemen_deskripsi" => $item["subelemen_deskripsi"],
                "elemen_deskripsi" => $item["elemen_deskripsi"],
                "dimensi_deskripsi" => $item["dimensi_deskripsi"]
            ];
        }

        // Reset keys to make the array sequential
        return array_values($formattedData);
    }
}
