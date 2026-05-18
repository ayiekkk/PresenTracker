<x-siswa-layout :kelas="$kelas" title="Dashboard">

    <div class="mb-8">
        <h1 class="text-xl font-bold text-gray-900">Dashboard Siswa</h1>
        <p class="text-xs text-gray-400 mt-0.5">Selamat datang kembali, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-50 text-emerald-600 border border-emerald-100/50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Hadir</p>
                    <p class="text-lg font-bold text-gray-800 mt-0.5">{{ $totalHadir }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-50 text-blue-600 border border-blue-100/50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Izin</p>
                    <p class="text-lg font-bold text-gray-800 mt-0.5">{{ $totalIzin }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-50 text-amber-600 border border-amber-100/50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Sakit</p>
                    <p class="text-lg font-bold text-gray-800 mt-0.5">{{ $totalSakit }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-rose-50 text-rose-600 border border-rose-100/50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Alpha</p>
                    <p class="text-lg font-bold text-gray-800 mt-0.5">{{ $totalAlpha }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Kehadiran --}}
    @php
        $totalPertemuan = $totalHadir + $totalIzin + $totalSakit + $totalAlpha;
        $persenHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100) : 0;
    @endphp

    <div class="bg-white rounded-xl p-5 border border-gray-200/80 shadow-sm shadow-black/[0.01] mb-6">
        <h3 class="text-xs font-bold text-gray-800 tracking-wide mb-3.5">Persentase Kehadiran</h3>
        <div class="flex items-center gap-4">
            <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                <div class="h-2.5 rounded-full transition-all duration-700
                    {{ $persenHadir >= 75 ? 'bg-emerald-500' : ($persenHadir >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}"
                     style="width: {{ $persenHadir }}%">
                </div>
            </div>
            <span class="text-lg font-black tracking-tight shrink-0
                {{ $persenHadir >= 75 ? 'text-emerald-600' : ($persenHadir >= 50 ? 'text-amber-600' : 'text-rose-600') }}">
                {{ $persenHadir }}%
            </span>
        </div>
        <p class="text-[10px] font-medium text-gray-400 mt-1.5">
            Mencakup {{ $totalHadir }} kehadiran dari total {{ $totalPertemuan }} pertemuan terdata
        </p>
    </div>

    {{-- Absensi Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/30">
            <h3 class="text-xs font-bold text-gray-800 tracking-wide">Riwayat Absensi Terbaru</h3>
        </div>

        @if($absensiTerbaru->isEmpty())
        <div class="text-center py-10">
            <div class="w-10 h-10 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <p class="text-[11px] font-medium text-gray-400">Belum ada riwayat absensi terbaru.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-32">Status</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-32">Waktu</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($absensiTerbaru as $absen)
                    <tr class="hover:bg-gray-50/40 transition duration-150">
                        <td class="px-6 py-3 text-xs font-semibold text-gray-800 tracking-wide">
                            {{ $absen->tanggal->isoFormat('dddd, D MMM Y') }}
                        </td>
                        <td class="px-6 py-3">
                            @php $color = match($absen->status) {
                                'hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'izin'  => 'bg-blue-50 text-blue-600 border-blue-100',
                                'sakit' => 'bg-amber-50 text-amber-600 border-amber-100',
                                default => 'bg-rose-50 text-rose-600 border-rose-100',
                            }; @endphp
                            <span class="inline-block border px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $color }}">
                                {{ $absen->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-xs text-gray-400 font-medium tracking-wide">
                            {{ $absen->waktu_absen?->format('H:i') ?? '-' }} WIB
                        </td>
                        <td class="px-6 py-3 text-xs text-gray-400 font-medium max-w-xs truncate">
                            {{ $absen->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</x-siswa-layout>