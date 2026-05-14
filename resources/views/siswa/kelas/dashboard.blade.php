<x-siswa-layout :kelas="$kelas" title="Dashboard">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Siswa</h1>
        <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }} 👋</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">✅</div>
                <div>
                    <p class="text-xs text-gray-500">Total Hadir</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalHadir }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">📝</div>
                <div>
                    <p class="text-xs text-gray-500">Total Izin</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalIzin }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">🤒</div>
                <div>
                    <p class="text-xs text-gray-500">Total Sakit</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalSakit }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-2xl">❌</div>
                <div>
                    <p class="text-xs text-gray-500">Total Alpha</p>
                    <p class="text-2xl font-bold text-red-600">{{ $totalAlpha }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Kehadiran --}}
    @php
        $totalPertemuan = $totalHadir + $totalIzin + $totalSakit + $totalAlpha;
        $persenHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100) : 0;
    @endphp

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Persentase Kehadiran</h3>
        <div class="flex items-center gap-4">
            <div class="flex-1 bg-gray-100 rounded-full h-4">
                <div class="h-4 rounded-full transition-all duration-700
                    {{ $persenHadir >= 75 ? 'bg-green-500' : ($persenHadir >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                     style="width: {{ $persenHadir }}%">
                </div>
            </div>
            <span class="text-2xl font-bold
                {{ $persenHadir >= 75 ? 'text-green-600' : ($persenHadir >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                {{ $persenHadir }}%
            </span>
        </div>
        <p class="text-xs text-gray-400 mt-2">
            {{ $totalHadir }} hadir dari {{ $totalPertemuan }} total pertemuan
        </p>
    </div>

    {{-- Absensi Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Riwayat Absensi Terbaru</h3>
        </div>

        @if($absensiTerbaru->isEmpty())
        <div class="text-center py-10">
            <div class="text-4xl mb-2">📋</div>
            <p class="text-gray-400 text-sm">Belum ada riwayat absensi</p>
        </div>
        @else
        <table class="w-full">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="text-left px-6 py-3">Tanggal</th>
                    <th class="text-left px-6 py-3">Status</th>
                    <th class="text-left px-6 py-3">Waktu</th>
                    <th class="text-left px-6 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($absensiTerbaru as $absen)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm text-gray-700">
                        {{ $absen->tanggal->isoFormat('dddd, D MMM Y') }}
                    </td>
                    <td class="px-6 py-3">
                        @php $color = match($absen->status) {
                            'hadir' => 'bg-green-100 text-green-700',
                            'izin'  => 'bg-blue-100 text-blue-700',
                            'sakit' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-red-100 text-red-700',
                        }; @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($absen->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500">
                        {{ $absen->waktu_absen?->format('H:i') ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500">
                        {{ $absen->keterangan ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</x-siswa-layout>