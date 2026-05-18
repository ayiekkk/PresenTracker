<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\User; // ← tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function cariKelas()
    {
        /** @var User $user */
        $user = Auth::user(); // ← tambahkan type hint

        $kelasSaya = $user->kelasSiswa()->get();

        return view('siswa.kelas.cari', compact('kelasSaya'));
    }

    public function joinKelas(Request $request)
    {
        $request->validate(['kode_kelas' => 'required|string']);

        $kelas = Kelas::where('kode_kelas', strtoupper($request->kode_kelas))->first();

        if (!$kelas) {
            return back()->with('error', 'Kode kelas tidak ditemukan!');
        }

        /** @var User $user */
        $user = Auth::user(); // ← tambahkan type hint

        if ($kelas->siswa()->where('siswa_id', $user->id)->exists()) {
            return redirect()->route('siswa.kelas.dashboard', $kelas)
                ->with('info', 'Anda sudah tergabung di kelas ini!');
        }

        $kelas->siswa()->attach($user->id);

        return redirect()->route('siswa.kelas.dashboard', $kelas)
            ->with('success', 'Berhasil bergabung ke kelas ' . $kelas->nama_kelas . '!');
    }

    public function dashboard(Kelas $kelas)
    {
        $this->cekAnggotaKelas($kelas);

        /** @var User $siswa */
        $siswa = Auth::user(); // ← tambahkan type hint

        $totalHadir = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'hadir')->count();

        $totalIzin = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'izin')->count();

        $totalSakit = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sakit')->count();

        $totalAlpha = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'alpha')->count();

        $absensiTerbaru = Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')->take(5)->get();

        return view('siswa.kelas.dashboard', compact(
            'kelas', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'absensiTerbaru'
        ));
    }

    public function daftarSiswa(Kelas $kelas)
    {
        $this->cekAnggotaKelas($kelas);
        $siswa = $kelas->siswa()->orderBy('name')->get();
        return view('siswa.kelas.siswa', compact('kelas', 'siswa'));
    }

    private function cekAnggotaKelas(Kelas $kelas): void
    {
        /** @var User $user */
        $user = Auth::user(); // ← tambahkan type hint

        if (!$kelas->siswa()->where('siswa_id', $user->id)->exists()) {
            abort(403, 'Anda bukan anggota kelas ini.');
        }
    }
}