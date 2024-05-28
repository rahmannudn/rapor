<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'wali_kelas';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->whereHas('user', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
        })->orWhereHas('kelas', function ($q) use ($value) {
            $q->where('nama', 'like', "%{$value}%");
        });
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
