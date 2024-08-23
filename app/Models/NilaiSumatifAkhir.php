<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSumatifAkhir extends Model
{
    use HasFactory;
    protected $table = 'nilai_sumatif_akhir';
    protected $guarded = ['id'];
}
