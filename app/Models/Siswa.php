<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->where('siswa.nama', 'like', "%{$value}%")->orWhere('siswa.nisn', 'like', "%{$value}%");
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun', 'tahun_lulus');
    }

    public function scopeJoinCatatanProyek($query)
    {
        $query->rightJoin('catatan_proyek', 'catatan_proyek.siswa_id', '=', 'siswa.id');
    }

    public function scopeJoinKelasSiswa($query)
    {
        $query->join('kelas_siswa', 'siswa.id', '=', 'kelas_siswa.siswa_id');
    }

    public function scopeJoinWaliKelasByKelasAndTahun($query, $kelasId, $taId)
    {
        $query->join('wali_kelas', function ($join)  use ($kelasId, $taId) {
            $join->on('kelas_siswa.kelas_id', '=', 'wali_kelas.kelas_id')
                ->where('kelas_siswa.kelas_id', '=', $kelasId)
                ->where('kelas_siswa.tahun_ajaran_id', '=', $taId)
                ->where('wali_kelas.tahun_ajaran_id', '=', $taId);
        });
    }

    public function scopeLeftJoinProyek($query)
    {
        $query->leftJoin('proyek', 'wali_kelas.id', '=', 'proyek.wali_kelas_id');
    }

    public function scopeLeftJoinCatatanProyek($query)
    {
        $query->leftJoin('catatan_proyek', function ($join) {
            $join->on('siswa.id', '=', 'catatan_proyek.siswa_id')
                ->on('proyek.id', '=', 'catatan_proyek.proyek_id');
        });
    }
}
