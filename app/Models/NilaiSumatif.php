<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSumatif extends Model
{
    use HasFactory;
    protected $table = 'nilai_sumatif';
    protected $guarded = ['id'];
}
