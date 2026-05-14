<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Kelas $kelas)
    {
        $this->authorize('view', $kelas);
        $tanggal = request('tanggal', today()->format('Y-m-d'));
        $siswaDiKelas = $kelas->siswa()->orderBy('name')->get();

        $absensiHari = Absensi::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggal)
            ->with('siswa')
            ->get()
            ->keyBy('siswa_id');

        return view('admin.kelas.absensi', compact('kelas', 'siswaDiKelas', 'absensiHari', 'tanggal'));
    }

    // AJAX endpoint untuk real-time refresh
    public function getData(Kelas $kelas)
    {
        $tanggal = request('tanggal', today()->format('Y-m-d'));
        $absensi = Absensi::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggal)
            ->with('siswa')
            ->get();

        return response()->json($absensi);
    }

    public function store(Request $request, Kelas $kelas)
    {
        $this->authorize('update', $kelas);
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::updateOrCreate(
            [
                'kelas_id' => $kelas->id,
                'siswa_id' => $request->siswa_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'waktu_absen' => now(),
            ]
        );

        return back()->with('success', 'Absensi berhasil disimpan!');
    }

    public function update(Request $request, Kelas $kelas, Absensi $absensi)
    {
        $this->authorize('update', $kelas);
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['success' => true, 'absensi' => $absensi]);
    }
}