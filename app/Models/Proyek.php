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
        $query->join('wali_kelas', 'proyek.wali_kelas_id', 'wali_kelas.id');
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'wali_kelas.user_id', 'users.id');
    }

    public function scopeJoinCapaianFase($query)
    {
        $query->join('capaian_fase', 'proyek.capaian_fase_id', 'capaian_fase.id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('proyek.judul_proyek', 'like', "%{$value}%")
                ->orWhere('proyek.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('capaianFase', function ($q) use ($value) {
                    $q->where('deskripsi', 'like', "%{$value}%");
                })->orWhereHas('waliKelas.user', function ($q) use ($value) {
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
}
