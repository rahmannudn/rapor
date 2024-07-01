<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianFase extends Model
{
    use HasFactory;
    protected $table = 'capaian_fase';
    protected $guarded = ['id'];

    public function subelemen()
    {
        return $this->belongsTo(Subelemen::class);
    }

    public function scopeJoinSubelemen($query)
    {
        $query->join('subelemen', 'capaian_fase.subelemen_id', 'subelemen.id');
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
            $q->where('capaian_fase.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('subelemen', function ($q) use ($value) {
                    $q->where('subelemen.deskripsi', 'like', "%{$value}%");
                })->orWhereHas('subelemen.elemen', function ($q) use ($value) {
                    $q->where('elemen.deskripsi', 'like', "%{$value}%");
                })->orWhereHas('subelemen.elemen.dimensi', function ($q) use ($value) {
                    $q->where('dimensi.deskripsi', 'like', "%{$value}%");
                });
        });
    }
}
