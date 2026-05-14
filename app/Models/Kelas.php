<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas', 'tingkat', 'jurusan', 'kode_kelas', 'admin_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kelas) {
            if (!$kelas->kode_kelas) {
                $kelas->kode_kelas = strtoupper(Str::random(6));
            }
        });
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'kelas_siswa', 'kelas_id', 'siswa_id')
                    ->withPivot('joined_at');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function absensiHariIni()
    {
        return $this->absensi()->whereDate('tanggal', today());
    }

    public function jumlahSiswa(): int
    {
        return $this->siswa()->count();
    }
}