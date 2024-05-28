<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
