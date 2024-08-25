<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiFormatif extends Model
{
    use HasFactory;
    protected $table = 'nilai_formatif';
    protected $guarded = ['id'];
}
