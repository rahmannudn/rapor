<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimensi extends Model
{
    use HasFactory;
    protected $table = 'dimensi';
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->where('deskripsi', 'like', "%{$value}%");
    }

    public function elemen()
    {
        return $this->hasMany(Elemen::class);
    }
}
