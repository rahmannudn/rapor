<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = ['id', 'created_at'];
    protected $primaryKey = 'id';

    public function scopeSearch($query, $value)
    {
        $query->where('nama', 'like', "%{$value}%")->orWhere('kelas', 'like', "%{$value}%");
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function materiMapel()
    {
        return $this->hasMany(MateriMapel::class);
    }

    public function detailGuruMapel()
    {
        return $this->hasMany(DetailGuruMapel::class);
    }

    public function scopeJoinWaliKelas($query, $taID)
    {
        $query->rightJoin('wali_kelas', function (JoinClause $q) use ($taID) {
            $q->on('wali_kelas.kelas_id', '=', 'kelas.id')
                ->where('wali_kelas.tahun_ajaran_id', '=', $taID);
        });
    }
}
