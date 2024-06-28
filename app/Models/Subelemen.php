<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subelemen extends Model
{
    use HasFactory;
    protected $table = 'subelemen';
    protected $guarded = ['id'];

    public function elemen()
    {
        return $this->belongsTo(Elemen::class);
    }

    public function scopeJoinElemen($query)
    {
        $query->join('elemen', 'subelemen.elemen_id', 'elemen.id');
    }

    public function scopeJoinDimensi($query)
    {
        $query->join('dimensi', 'elemen.dimensi_id', 'dimensi.id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('subelemen.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('elemen', function ($q) use ($value) {
                    $q->where('elemen.deskripsi', 'like', "%{$value}%");
                })->orWhereHas('elemen.dimensi', function ($q) use ($value) {
                    $q->where('dimensi.deskripsi', 'like', "%{$value}%");
                });
        });
    }
}
