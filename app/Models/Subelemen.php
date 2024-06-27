<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subelemen extends Model
{
    use HasFactory;
    protected $table = 'subelemen';
    protected $guarded = ['id'];
}
