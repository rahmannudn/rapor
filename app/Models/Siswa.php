<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->where('siswa.nama', 'like', "%{$value}%")->orWhere('siswa.nisn', 'like', "%{$value}%");
    }

    public function scopeSearchNilaiEkskul($query, $value)
    {
        // $query->where(function ($query) use ($value){
        //     $query->where('siswa.nama', 'like', "%{$value}%")
        //     ->orWhere('siswa.nisn', 'like', "%{$value}%")
        //     ->orWhereHas('kelasSiswa.ekskul',function($q) use($value){
        //         $q->where('nama_ekskul','like',"%$value%");
        //     })
        // });
        // ->where()
        // $query->where(function ($q) use ($value) {
        //     $q->where('capaian_fase.deskripsi', 'like', "%{$value}%")
        //         ->orWhereHas('subelemen', function ($q) use ($value) {
        //             $q->where('subelemen.deskripsi', 'like', "%{$value}%");
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun', 'tahun_lulus');
    }

    public function scopeJoinCatatanProyek($query)
    {
        $query->rightJoin('catatan_proyek', 'catatan_proyek.siswa_id', '=', 'siswa.id');
    }
    public function scopeLeftJoinProyek($query)
    {
        $query->leftJoin('proyek', 'wali_kelas.id', '=', 'proyek.wali_kelas_id');
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

    public function scopeJoinAndSearchKelasSiswa($query, $tahunAjaranId)
    {
        $query->leftJoin('kelas_siswa', function (JoinClause $q) use ($tahunAjaranId) {
            $q->on('kelas_siswa.siswa_id', '=', 'siswa.id')
                ->where('kelas_siswa.tahun_ajaran_id', '=', $tahunAjaranId);
        });
    }

    public function scopeSearchAndJoinProyek($query, $proyekId)
    {
        $query->join('proyek', function (JoinClause $q) use ($proyekId) {
            $q->on('wali_kelas.id', '=', 'proyek.wali_kelas_id')
                ->where('proyek.id', '=', $proyekId);
        });
    }

    public function scopeJoinSubproyek($query)
    {
        $query->join('subproyek', 'subproyek.proyek_id', '=', 'proyek.id');
    }

    public function scopeLeftJoinRapor($query)
    {
        $query->leftJoin('rapor', 'rapor.kelas_siswa_id', '=', 'kelas_siswa.id');
    }

    public function scopeLeftJoinNilaiSubproyek($query)
    {
        $query->leftJoin('nilai_subproyek', function (JoinClause $q) {
            $q->on('nilai_subproyek.subproyek_id', '=', 'subproyek.id')
                ->on('nilai_subproyek.kelas_siswa_id', '=', 'kelas_siswa.id');
        });
    }

    public function scopeLeftJoinCapaianFase($query)
    {
        $query->leftJoin('capaian_fase', 'subproyek.capaian_fase_id', '=', 'capaian_fase.id');
    }

    public function scopeLeftJoinCatatanProyek($query)
    {
        $query->leftJoin('catatan_proyek', function ($join) {
            $join->on('siswa.id', '=', 'catatan_proyek.siswa_id')
                ->on('proyek.id', '=', 'catatan_proyek.proyek_id');
        });
    }
}
