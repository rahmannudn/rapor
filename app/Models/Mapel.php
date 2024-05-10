<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $table = 'mapel';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->where('nama_mapel', 'like', "%{$value}%");
    }
}
