<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;
    protected $table = 'guru_mapel';
    protected $guarded = ['id'];

    public function detailGuruMapel()
    {
        return $this->hasMany(DetailGuruMapel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function scopeJoinUsers($query)
    {
        $query->join('users', 'guru_mapel.user_id', '=', 'users.id');
    }

    public function scopeJoinDetailGuruMapel($query)
    {
        $query->join('detail_guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id');
    }

    public function scopeJoinKelasByDetail($query)
    {
        $query->join('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id');
    }
}
