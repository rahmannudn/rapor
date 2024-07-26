<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class KelasSiswa extends Model
{
    use HasFactory;
    protected $table = 'kelas_siswa';
    protected $guarded = ['id'];

    public function scopeJoinSiswa($query)
    {
        $query->rightJoin('siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id');
    }

    public function scopeJoinKelas($query)
    {
        $query->leftJoin('kelas', 'kelas_siswa.kelas_id', '=', 'kelas.id');
    }

    public function scopeSearchAndJoinWaliKelas($query, $taId, $kelasId)
    {
        $query->leftJoin('wali_kelas', function (JoinClause $q) use ($taId, $kelasId) {
            $q->on('kelas.id', '=', 'wali_kelas.kelas_id')
                ->where('wali_kelas.kelas_id', '=', $kelasId)
                ->where('wali_kelas.tahun_ajaran_id', '=', $taId);
        });
    }

    public function scopeSearchAndJoinProyek($query, $proyekId)
    {
        $query->leftJoin('proyek', function (JoinClause $q) use ($proyekId) {
            $q->on('proyek.wali_kelas_id', '=', 'wali_kelas.id')
                ->where('proyek.id', '=', $proyekId);
        });
    }

    public function scopeJoinSubproyekByProyek($query)
    {
        $query->leftJoin('subproyek', 'subproyek.proyek_id', '=', 'proyek.id');
    }

    public function scopeJoinNilaiSubproyekBySubproyek($query)
    {
        $query->leftJoin('nilai_subproyek', 'nilai_subproyek.subproyek_id', '=', 'subproyek.id');
    }

    public function scopeJoinCapaianFaseBySubproyek($query)
    {
        $query->join('capaian_fase', 'subproyek.capaian_fase_id', '=', 'capaian_fase.id');
    }
}
