<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiProyek extends Model
{
    use HasFactory;

    protected $table = 'nilai_proyek';
    protected $guarded = ['id'];
}
