<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elemen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'elemen';

    public function dimensi()
    {
        return $this->belongsTo(Dimensi::class);
    }

    public function scopeJoinDimensi($query)
    {
        $query->join('dimensi', 'elemen.dimensi_id', 'dimensi.id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('elemen.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('dimensi', function ($q) use ($value) {
                    $q->where('deskripsi', 'like', "%{$value}%");
                });
        });
    }
}
