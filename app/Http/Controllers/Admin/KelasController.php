<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('admin_id', Auth::id())
            ->withCount('siswa')
            ->latest()
            ->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string|max:100',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'admin_id' => Auth::id(),
        ]);

        return back()->with('success', 'Kelas berhasil dibuat!');
    }

    public function update(Request $request, Kelas $kelas)
    {
        abort_if($kelas->admin_id !== Auth::id(), 403);
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string|max:100',
        ]);
        $kelas->update($request->only('nama_kelas', 'tingkat', 'jurusan'));
        return back()->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy(Kelas $kelas)
    {
        $this->authorize('delete', $kelas);
        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus!');
    }

    public function dashboard(Kelas $kelas)
    {
        $this->authorize('view', $kelas);

        $totalSiswa = $kelas->siswa()->count();
        $hadirHariIni = $kelas->absensiHariIni()->where('status', 'hadir')->count();
        $izinHariIni = $kelas->absensiHariIni()->where('status', 'izin')->count();
        $sakitHariIni = $kelas->absensiHariIni()->where('status', 'sakit')->count();
        $alphaHariIni = $totalSiswa - $kelas->absensiHariIni()->count();
        $absensiMingguIni = Absensi::where('kelas_id', $kelas->id)
            ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('tanggal, status, COUNT(*) as total')
            ->groupBy('tanggal', 'status')
            ->get();

        return view('admin.kelas.dashboard', compact(
            'kelas',
            'totalSiswa',
            'hadirHariIni',
            'izinHariIni',
            'sakitHariIni',
            'alphaHariIni',
            'absensiMingguIni'
        ));
    }
}
