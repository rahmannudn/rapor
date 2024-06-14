<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepsek extends Model
{
    use HasFactory;
    protected $table = 'kepsek';
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->WhereHas('user', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
        })
            ->orWhereHas('awalTahunAjaran', function ($q) use ($value) {
                $q->where('tahun', 'like', "%{$value}%")
                    ->orWhere('semester', 'like', "%{$value}%");
            })
            ->orWhereHas('akhirTahunAjaran', function ($q) use ($value) {
                $q->where('tahun', 'like', "%{$value}%")
                    ->orWhere('semester', 'like', "%{$value}%");
            });
    }

    public function awalTahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'awal_menjabat');
    }

    public function akhirTahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'akhir_menjabat');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeJoinAwalJabatan($query)
    {
        $query->join('tahun_ajaran as awal_tahun', 'kepsek.awal_menjabat', '=', 'awal_tahun.id');
    }

    public function scopeJoinAkhirJabatan($query)
    {
        $query->leftJoin('tahun_ajaran as akhir_tahun', 'kepsek.akhir_menjabat', '=', 'akhir_tahun.id');
    }

    public function scopeJoinUser($query)
    {
        $query->join('users', 'kepsek.user_id', '=', 'users.id');
    }

    public function scopeJoinTahunAjaran($query)
    {
        $query->join('tahun_ajaran', 'kepsek.awal_menjabat', '=', 'tahun_ajaran.id');
    }
}
