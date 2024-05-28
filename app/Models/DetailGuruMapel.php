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
        return $this->hasMany(Kelas::class);
    }

    public function dataGuru()
    {
        return $this->hasManyThrough(User::class, GuruMapel::class);
    }
}
