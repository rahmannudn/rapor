<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianFase extends Model
{
    use HasFactory;
    protected $table = 'capaian_fase';
    protected $guarded = ['id'];
}
