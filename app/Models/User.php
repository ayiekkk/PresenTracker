<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nis', 'jenis_kelamin', 'alamat',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // Admin punya banyak kelas
    public function kelasYangDikelola()
    {
        return $this->hasMany(Kelas::class, 'admin_id');
    }

    // Siswa bergabung ke banyak kelas
    public function kelasSiswa()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
                    ->withPivot('joined_at');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}