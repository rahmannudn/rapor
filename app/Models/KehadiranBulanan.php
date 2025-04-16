<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranBulanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "kehadiran_bulanan";
}
