<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = ['kelas_id', 'siswa_id', 'tanggal', 'status', 'keterangan', 'waktu_absen'];

    protected $casts = ['tanggal' => 'date', 'waktu_absen' => 'datetime'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}