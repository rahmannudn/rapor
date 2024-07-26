<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSubproyek extends Model
{
    use HasFactory;

    protected $table = 'nilai_subproyek';
    protected $guarded = ['id'];

    public static function convertNilaiData($nilaiData)
    {
        $results = [];

        foreach ($nilaiData as $siswaId => $records) {
            $siswa = [
                'siswa_id' => $siswaId,
                'nama_siswa' => $records->first()->nama_siswa,
                'kelas_siswa_id' => $records->first()->kelas_siswa_id,
            ];

            $nilai = [];
            foreach ($records as $index => $record) {
                $nilaiKey = 'nilai_' . ($index + 1);
                $nilai[$nilaiKey] = [
                    'subproyek_id' => $record->subproyek_id,
                    'nilai' => $record->nilai_subproyek,
                    'nilai_id' => $record->nilai_subproyek_id
                ];
            }
            $siswa['nilai'] = $nilai;
            $results[] = $siswa;
        }
        return $results;
    }
}
