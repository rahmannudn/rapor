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

    public function scopeJoinWaliKelas($query)
    {
        $query->join('wali_kelas', 'proyek.wali_kelas_id', 'wali_kelas.id');
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'wali_kelas.user_id', 'users.id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('judul_proyek', 'like', "%{$value}%")
                ->orWhere('deskripsi', 'like', "%{$value}%");
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
