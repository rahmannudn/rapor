<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanProyek extends Model
{
    use HasFactory;
    protected $table = 'catatan_proyek';
    protected $guarded = ['id'];
}
