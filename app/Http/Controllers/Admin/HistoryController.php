<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Kelas $kelas)
    {
        $this->authorize('view', $kelas);

        $bulan = request('bulan', now()->format('Y-m'));
        [$tahun, $bln] = explode('-', $bulan);

        $history = Absensi::where('kelas_id', $kelas->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bln)
            ->with('siswa')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->tanggal->format('Y-m-d'));

        $totalSiswa = $kelas->siswa()->count();

        return view('admin.kelas.history', compact('kelas', 'history', 'totalSiswa', 'bulan'));
    }
}