<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class CatatanProyek extends Model
{
    use HasFactory;
    protected $table = 'catatan_proyek';
    protected $guarded = ['id'];

    public function scopeJoinProyek($query)
    {
        $query->rightJoin('proyek', 'catatan_proyek.proyek_id', '=', 'proyek.id');
    }

    public function scopeJoinSiswa($query)
    {
        $query->rightJoin('siswa', 'catatan_proyek.siswa_id', '=', 'siswa.id');
    }

    public function scopeJoinWaliKelas($query, $taId, $kelasId)
    {
        $query->join('wali_kelas', function (JoinClause $q) use ($taId, $kelasId) {
            $q->on('proyek.wali_kelas_id', '=', 'wali_kelas.id')
                ->where('wali_kelas.tahun_ajaran_id', '=', $taId)
                ->where('wali_kelas.kelas_id', '=', $kelasId);
        });
    }

    public static function getDaftarKelas($taid)
    {
        return Kelas::query()
            ->joinWaliKelas($taid)
            ->joinProyek()
            ->select('kelas.id', 'kelas.nama')
            ->distinct()
            ->get();
    }

    // mengconvert beberapa collection yang memiliki data seperti id_siswa yang serupa menjadi satu
    // contohnya
    // $data = [
    //     [
    //         'id_siswa' : 1,
    //         'nama' : jajang,
    //         'id_proyek' : 1,
    //         'catatan' : belajar sungguh2
    //     ],
    //     [
    //         'id_siswa' : 1,
    //         'nama' : jajang,
    //         'catatan' : perkembangan yang baik
    //     ],
    // ]

    // RESULT:
    // [
    //     [
    //         'id_siswa' : 1,
    //         'nama' : jajang,
    //         'catatan' : ['belajar sungguh2', 'perkembangan yang baik']
    //     ],
    // ]
    public static function convertProyekData($data)
    {
        $result = [];

        foreach ($data as $siswaId => $records) {
            $siswa = [
                'siswa_id' => $siswaId,
                'nama_siswa' => $records->first()->nama_siswa,
            ];

            $catatanProyek = [];
            foreach ($records as $index => $record) {
                $catatanKey = 'catatan_proyek_' . ($index + 1);
                $catatanProyek[$catatanKey] = [
                    'proyek_id' => $record->proyek_id,
                    'catatan' => $record->catatan,
                    'catatan_id' => $record->catatan_id
                ];
            }

            $siswa['catatan_proyek'] = $catatanProyek;
            $result[] = $siswa;
        }

        return $result;
    }
}
