<x-admin-layout :kelas="$kelas">
    <x-slot name="title">History Absensi</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">History Absensi</h1>
            <p class="text-xs text-gray-400 mt-0.5">Riwayat rekapitulasi kehadiran siswa per hari</p>
        </div>
        <input type="month" value="{{ $bulan }}"
               class="border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-150 shadow-sm shadow-black/[0.01]"
               onchange="window.location.href='?bulan='+this.value">
    </div>

    @if($history->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01]">
        <div class="w-12 h-12 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        </div>
        <p class="text-xs font-medium text-gray-400">Belum ada data absensi bulan ini.</p>
    </div>
    @else
    <div class="space-y-6">
        @foreach($history as $tanggal => $absensiPerHari)
        @php
            $hadir = $absensiPerHari->where('status', 'hadir')->count();
            $izin = $absensiPerHari->where('status', 'izin')->count();
            $sakit = $absensiPerHari->where('status', 'sakit')->count();
            $alpha = $absensiPerHari->where('status', 'alpha')->count();
        @endphp
        
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center border border-blue-100/50 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <p class="text-[10px] font-medium text-gray-400 mt-0.5">{{ $absensiPerHari->count() }} dari {{ $totalSiswa }} siswa tercatat</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-1.5 text-[10px] font-bold tracking-wide">
                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2 py-0.5 rounded-md">H: {{ $hadir }}</span>
                    <span class="bg-blue-50 text-blue-600 border border-blue-100 px-2 py-0.5 rounded-md">I: {{ $izin }}</span>
                    <span class="bg-amber-50 text-amber-600 border border-amber-100 px-2 py-0.5 rounded-md">S: {{ $sakit }}</span>
                    <span class="bg-rose-50 text-rose-600 border border-rose-100 px-2 py-0.5 rounded-md">A: {{ $alpha }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-white">
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-32">Waktu Absen</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-32">Status</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($absensiPerHari as $absen)
                        <tr class="hover:bg-gray-50/40 transition duration-150">
                            <td class="px-6 py-3 text-xs font-semibold text-gray-800 tracking-wide">
                                {{ $absen->siswa->name }}
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-400 font-medium tracking-wide">
                                {{ $absen->waktu_absen?->format('H:i') ?? '-' }} WIB
                            </td>
                            <td class="px-6 py-3">
                                @php 
                                    $color = match($absen->status) {
                                        'hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'izin' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'sakit' => 'bg-amber-50 text-amber-50 border-amber-100',
                                        default => 'bg-rose-50 text-rose-600 border-rose-100',
                                    }; 
                                @endphp
                                <span class="inline-block border px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $color }}">
                                    {{ $absen->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-400 font-medium truncate max-w-xs">
                                {{ $absen->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-admin-layout>