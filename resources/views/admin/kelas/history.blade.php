<x-admin-layout :kelas="$kelas">
    <x-slot name="title">History Absensi</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">History Absensi</h1>
            <p class="text-gray-500 mt-1">Riwayat kehadiran per hari</p>
        </div>
        <input type="month" value="{{ $bulan }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm"
               onchange="window.location.href='?bulan='+this.value">
    </div>

    @if($history->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl border border-gray-100">
        <div class="text-5xl mb-3">📋</div>
        <p class="text-gray-500">Belum ada data absensi bulan ini.</p>
    </div>
    @else
    <div class="space-y-4">
        @foreach($history as $tanggal => $absensiPerHari)
        @php
            $hadir = $absensiPerHari->where('status', 'hadir')->count();
            $izin = $absensiPerHari->where('status', 'izin')->count();
            $sakit = $absensiPerHari->where('status', 'sakit')->count();
            $alpha = $absensiPerHari->where('status', 'alpha')->count();
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-lg">📅</span>
                    <div>
                        <p class="font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $absensiPerHari->count() }} dari {{ $totalSiswa }} siswa tercatat</p>
                    </div>
                </div>
                <div class="flex gap-3 text-sm">
                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">✅ {{ $hadir }}</span>
                    <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-medium">📝 {{ $izin }}</span>
                    <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full font-medium">🤒 {{ $sakit }}</span>
                    <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-medium">❌ {{ $alpha }}</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs text-gray-500 bg-gray-50/50">
                        <tr>
                            <th class="text-left px-6 py-3">Nama Siswa</th>
                            <th class="text-left px-6 py-3">Waktu</th>
                            <th class="text-left px-6 py-3">Status</th>
                            <th class="text-left px-6 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($absensiPerHari as $absen)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $absen->siswa->name }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $absen->waktu_absen?->format('H:i') ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @php $color = match($absen->status) {
                                    'hadir' => 'bg-green-100 text-green-700',
                                    'izin' => 'bg-blue-100 text-blue-700',
                                    'sakit' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-red-100 text-red-700',
                                }; @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($absen->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $absen->keterangan ?? '-' }}</td>
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