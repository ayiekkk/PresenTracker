<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Kelas $kelas)
    {
        $isMember = $kelas->siswa()->where('siswa_id', Auth::id())->exists();
        if (!$isMember) abort(403);

        $sudahAbsen = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        return view('siswa.kelas.absensi', compact('kelas', 'sudahAbsen'));
    }

    public function presensi(Request $request, Kelas $kelas)
    {
        $isMember = $kelas->siswa()->where('siswa_id', Auth::id())->exists();
        if (!$isMember) abort(403);

        $request->validate(['keterangan' => 'nullable|string|max:255']);

        $sudahAbsen = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', Auth::id())
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        Absensi::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => Auth::id(),
            'tanggal' => today(),
            'status' => 'hadir',
            'keterangan' => $request->keterangan,
            'waktu_absen' => now(),
        ]);

        return back()->with('success', 'Presensi berhasil! Selamat belajar 🎉');
    }
}