<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;
    protected $table = 'ekskul';
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->where('nama_ekskul', 'like', "%{$value}%");
    }
}
