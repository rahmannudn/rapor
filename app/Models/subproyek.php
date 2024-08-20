<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class Subproyek extends Model
{
    use HasFactory;
    protected $table = 'subproyek';
    protected $guarded = ['id'];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function scopeSearchAndJoinProyek($query, $proyekId)
    {
        $query->join('proyek', function (JoinClause $q) use ($proyekId) {
            $q->on('subproyek.proyek_id', '=', 'proyek.id')
                ->where('proyek.id', '=', $proyekId);
        });
    }

    public function scopeJoinCapaianFase($query)
    {
        $query->join('capaian_fase', 'subproyek.capaian_fase_id', '=', 'capaian_fase.id');
    }

    public function scopeJoinSubelemen($query)
    {
        $query->join('subelemen', 'capaian_fase.subelemen_id', '=', 'subelemen.id');
    }

    public function scopeJoinElemen($query)
    {
        $query->join('elemen', 'subelemen.elemen_id', '=', 'elemen.id');
    }

    public function scopeJoinDimensi($query)
    {
        $query->join('dimensi', 'elemen.dimensi_id', '=', 'dimensi.id');
    }
}
