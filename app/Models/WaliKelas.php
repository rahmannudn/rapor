<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;
    protected $table = 'wali_kelas';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        // $query->where('nama', 'like', "%{$value}%")->orWhere('nisn', 'like', "%{$value}%");
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
