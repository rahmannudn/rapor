<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class LingkupMateri extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'lingkup_materi';

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('deskripsi', 'like', "%{$value}%")
                ->orWhereHas('detailGuruMapel.mapel', function ($q) use ($value) {
                    $q->where('nama_mapel', 'like', "%{$value}%");
                })->orWhereHas('detailGuruMapel.kelas', function ($q) use ($value) {
                    $q->where('nama', 'like', "%{$value}%");
                })->orWhereHas('detailGuruMapel.guruMapel.user', function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                });
        });
    }

    public function detailGuruMapel()
    {
        return $this->belongsTo(DetailGuruMapel::class);
    }

    public function scopeJoinDetailGuruMapel($query)
    {
        $query->join('detail_guru_mapel', 'lingkup_materi.detail_guru_mapel_id', 'detail_guru_mapel.id');
    }

    public function scopeJoinGuruMapel($query)
    {
        $query->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', 'guru_mapel.id');
    }

    public function scopeJoinKelas($query)
    {
        $query->join('kelas', 'detail_guru_mapel.kelas_id', 'kelas.id');
    }

    public function scopeJoinMapel($query)
    {
        $query->join('mapel', 'detail_guru_mapel.mapel_id', 'mapel.id');
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'guru_mapel.user_id', 'users.id');
    }

    public function scopeSearchAndJoinMapel($query, $mapelId)
    {
        $query->join('mapel', function (JoinClause $q) use ($mapelId) {
            $q->on('detail_guru_mapel.mapel_id', '=', 'mapel.id');
            if ($mapelId) {
                $q->where('detail_guru_mapel.mapel_id', '=', $mapelId);
            }
        });
    }

    public function scopeSearchAndJoinKelas($query, $kelasId,)
    {
        $query->join('kelas', function (JoinClause $q) use ($kelasId,) {
            $q->on('detail_guru_mapel.kelas_id', 'kelas.id')
                ->where('detail_guru_mapel.kelas_id', '=', $kelasId);
        });
    }

    public function scopeSearchAndJoinUsers($query, $userId)
    {
        $query->join('users', function (JoinClause $q) use ($userId) {
            $q->on('guru_mapel.user_id', 'users.id');
            if ($userId) {
                $q->where('guru_mapel.user_id', '=', $userId);
            }
        });
    }

    public function scopeSearchAndJoinTahunAjaran($query, $taId)
    {
        $query->join('tahun_ajaran', function (JoinClause $q) use ($taId) {
            $q->on('guru_mapel.tahun_ajaran_id', 'tahun_ajaran.id');
            if ($taId) {
                $q->where('guru_mapel.tahun_ajaran_id', '=', $taId);
            }
        });
    }
}
