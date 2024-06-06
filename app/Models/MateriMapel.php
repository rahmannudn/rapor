<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriMapel extends Model
{
    use HasFactory;
    protected $table = 'materi_mapel';
    protected $guarded = ['id'];
}
