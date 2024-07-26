<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class Proyek extends Model
{
    use HasFactory;
    protected $table = 'proyek';
    protected $guarded = ['id'];

    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class);
    }

    public function capaianFase()
    {
        return $this->belongsTo(CapaianFase::class);
    }

    public function scopeJoinWaliKelas($query)
    {
        $query->join('wali_kelas', 'proyek.wali_kelas_id', '=', 'wali_kelas.id');
    }

    public function scopeJoinAndSearchWaliKelas($query, $taId, $kelasId)
    {
        $query->join('wali_kelas', function (JoinClause $q) use ($taId, $kelasId) {
            $q->on('proyek.wali_kelas_id', 'wali_kelas.id')
                ->where('wali_kelas.tahun_ajaran_id', $taId)
                ->where('wali_kelas.kelas_id', $kelasId);
        });
    }

    public function scopeJoinSubproyek($query)
    {
        $query->join('subproyek', 'subproyek.proyek_id', '=', 'proyek.id');
    }

    public function scopeJoinCapaianFase($query)
    {
        $query->join('capaian_fase', 'subproyek.capaian_fase_id', '=', 'capaian_fase.id');
    }

    public function scopeJoinSubelemen($query)
    {
        $query->join('subelemen', 'capaian_fase.subelemen_id', '=', 'subelemen.id');
    }

    public function scopeJoinElemen($query)
    {
        $query->join('elemen', 'subelemen.elemen_id', '=', 'elemen.id');
    }

    public function scopeJoinDimensi($query)
    {
        $query->join('dimensi', 'elemen.dimensi_id', '=', 'dimensi.id');
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'wali_kelas.user_id', 'users.id');
    }

    public function scopeJoinKelasByWaliKelas($query)
    {
        $query->join('kelas', 'wali_kelas.kelas_id', 'kelas.id');
    }

    public function scopeJoinTahunByWaliKelas($query)
    {
        $query->join('tahun_ajaran', 'wali_kelas.tahun_ajaran_id', 'tahun_ajaran.id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('proyek.judul_proyek', 'like', "%{$value}%")
                ->orWhere('proyek.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('waliKelas.user', function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                })->orWhereHas('waliKelas.kelas', function ($q) use ($value) {
                    $q->where('kelas.nama', 'like', "%{$value}%");
                });
        });
    }

    public function scopeFilterKelas($query, $kelasId)
    {
        $query->join('kelas', function (JoinClause $q) use ($kelasId) {
            $q->on('wali_kelas.kelas_id', '=', 'kelas.id');
            if ($kelasId) {
                $q->where('kelas.id', '=', $kelasId);
            }
        });
    }

    public function scopeFilterTahunAjaran($query, $taId)
    {
        $query->join('tahun_ajaran', function (JoinClause $q) use ($taId) {
            $q->on('wali_kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id');
            if ($taId) {
                $q->where('tahun_ajaran.id', '=', $taId);
            }
        });
    }

    public static function convertProyekData($data)
    {
        $result = [];

        foreach ($data as $proyekId => $records) {
            $proyek = [
                'proyek_id' => $proyekId,
                'judul_proyek' => $records['judul_proyek']
            ];

            $subproyek = [];
            foreach ($records as $index => $record) {
                $subproyekKey = "subproyek_" + ($index + 1);
            }
        }
    }
}
