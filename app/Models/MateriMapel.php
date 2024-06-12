<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\JoinClause;

class MateriMapel extends Model
{
    use HasFactory;
    protected $table = 'materi_mapel';
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('tujuan_pembelajaran', 'like', "%{$value}%")
                ->orWhere('lingkup_materi', 'like', "%{$value}%")
                ->orWhereHas('detailGuruMapel.mapel', function ($q) use ($value) {
                    $q->where('nama_mapel', 'like', "%{$value}%");
                })
                ->orWhereHas('detailGuruMapel.kelas', function ($q) use ($value) {
                    $q->where('nama', 'like', "%{$value}%");
                })
                ->orWhereHas('detailGuruMapel.guruMapel.user', function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                });
        });
    }

    public function scopeJoinDetailGuruMapel($query)
    {
        $query->join('detail_guru_mapel', 'materi_mapel.detail_guru_mapel_id', '=', 'detail_guru_mapel.id');
    }

    public function scopeJoinGuruMapel($query)
    {
        $query->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id');
    }

    public function scopeSearchUserByJoinGuruMapel($query, $userId)
    {
        $query->join('guru_mapel', function (JoinClause $query) use ($userId) {
            $query->on('detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id');
            if ($userId) {
                $query->where('detail_guru_mapel.user_id', '=', $userId);
            }
        });
    }

    public function scopeSearchAndJoinKelas($query, $kelasId)
    {
        $query->join('kelas', function (JoinClause $query) use ($kelasId) {
            $query->on('detail_guru_mapel.kelas_id', '=', 'kelas.id');
            if ($kelasId) {
                $query->where('detail_guru_mapel.kelas_id', '=', $kelasId);
            }
        });
    }

    public function scopeSearchAndJoinMapel($query, $mapelId)
    {
        $query->join('mapel', function (JoinClause $query) use ($mapelId) {
            $query->on('detail_guru_mapel.mapel_id', '=', 'mapel.id');
            if ($mapelId) {
                $query->where('detail_guru_mapel.mapel_id', '=', $mapelId);
            }
        });
    }

    public function scopeSearchAndJoinTahunAjaran($query, $taId)
    {
        $query->join('tahun_ajaran', function (JoinClause $query) use ($taId) {
            $query->on('guru_mapel.tahun_ajaran_id', '=', 'tahun_ajaran.id');
            if ($taId) {
                $query->where('guru_mapel.tahun_ajaran_id', '=', $taId);
            }
        });
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'guru_mapel.user_id', '=', 'users.id');
    }

    public function detailGuruMapel()
    {
        return $this->belongsTo(DetailGuruMapel::class, 'detail_guru_mapel_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
