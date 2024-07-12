<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailGuruMapel extends Model
{
    use HasFactory;
    protected $table = 'detail_guru_mapel';
    protected $guarded = ['id'];

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class);
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function dataGuru()
    {
        return $this->hasManyThrough(User::class, GuruMapel::class);
    }

    public function materiMapel()
    {
        return $this->hasMany(MateriMapel::class);
    }

    public function scopeJoinKelas($query)
    {
        $query->join('kelas', 'detail_guru_mapel.kelas_id', 'kelas.id');
    }

    public function scopeJoinGuruMapel($query)
    {
        $query->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id');
    }
}
