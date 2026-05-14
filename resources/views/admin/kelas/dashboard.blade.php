<x-admin-layout :kelas="$kelas">
    <x-slot name="title">Dashboard {{ $kelas->nama_kelas }}</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard {{ $kelas->nama_kelas }}</h1>
        <p class="text-gray-500 mt-1">Ringkasan absensi hari ini - {{ now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">👨‍🎓</div>
                <div>
                    <p class="text-xs text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">✅</div>
                <div>
                    <p class="text-xs text-gray-500">Hadir</p>
                    <p class="text-2xl font-bold text-green-600">{{ $hadirHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">📝</div>
                <div>
                    <p class="text-xs text-gray-500">Izin/Sakit</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $izinHariIni + $sakitHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-2xl">❌</div>
                <div>
                    <p class="text-xs text-gray-500">Alpha</p>
                    <p class="text-2xl font-bold text-red-600">{{ $alphaHariIni }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Kehadiran -->
    @if($totalSiswa > 0)
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tingkat Kehadiran Hari Ini</h3>
        @php $persen = $totalSiswa > 0 ? round(($hadirHariIni/$totalSiswa)*100) : 0; @endphp
        <div class="flex items-center gap-4">
            <div class="flex-1 bg-gray-100 rounded-full h-4">
                <div class="bg-green-500 h-4 rounded-full transition-all duration-700"
                     style="width: {{ $persen }}%"></div>
            </div>
            <span class="text-2xl font-bold text-green-600">{{ $persen }}%</span>
        </div>
    </div>
    @endif

    <!-- Info Kode Kelas -->
    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 flex items-center justify-between">
        <div>
            <p class="text-sm text-indigo-600 font-medium">Kode Kelas untuk Siswa</p>
            <p class="font-mono text-3xl font-bold text-indigo-800 tracking-widest mt-1">{{ $kelas->kode_kelas }}</p>
        </div>
        <button onclick="navigator.clipboard.writeText('{{ $kelas->kode_kelas }}').then(() => alert('Kode disalin!'))"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
            📋 Copy Kode
        </button>
    </div>
</x-admin-layout>