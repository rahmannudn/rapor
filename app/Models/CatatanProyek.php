<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanProyek extends Model
{
    use HasFactory;
    protected $table = 'catatan_proyek';
    protected $guarded = ['id'];

    public function scopeJoinProyek($query)
    {
        $query->join('proyek', 'catatan_proyek.proyek_id', '=', 'proyek.id');
    }

    public function scopeJoinSiswa($query)
    {
        $query->join('siswa', 'catatan_proyek.siswa_id', '=', 'siswa.id');
    }

    public function scopeJoinWaliKelas($query)
    {
        $query->join('wali_kelas', 'proyek.wali_kelas_id', '=', 'wali_kelas.id');
    }
}
