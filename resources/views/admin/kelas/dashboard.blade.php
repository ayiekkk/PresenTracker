<x-admin-layout :kelas="$kelas">
    <x-slot name="title">Dashboard {{ $kelas->nama_kelas }}</x-slot>

    <div class="mb-8">
        <h1 class="text-xl font-bold text-gray-900">Dashboard {{ $kelas->nama_kelas }}</h1>
        <p class="text-xs text-gray-400 mt-0.5">Rangkuman aktivitas dan absensi hari ini</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-xl p-5 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSiswa }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center border border-blue-100/50 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Siswa Hadir</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $hadirHariIni }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center border border-emerald-100/50 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Izin & Sakit</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1">{{ $izinHariIni + $sakitHariIni }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center border border-amber-100/50 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200/80 shadow-sm shadow-black/[0.01]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tanpa Keterangan</p>
                    <p class="text-2xl font-bold text-rose-600 mt-1">{{ $alphaHariIni }}</p>
                </div>
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center border border-rose-100/50 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    @if($totalSiswa > 0)
    <div class="bg-white rounded-xl p-6 border border-gray-200/80 shadow-sm shadow-black/[0.01] mb-6">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rasio Kehadiran Hari Ini</h3>
            @php $persen = $totalSiswa > 0 ? round(($hadirHariIni/$totalSiswa)*100) : 0; @endphp
            <span class="text-sm font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">{{ $persen }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
            <div class="bg-blue-600 h-full rounded-full transition-all duration-700 ease-out"
                 style="width: {{ $persen }}%"></div>
        </div>
    </div>
    @endif

    <div class="bg-white border border-blue-100 rounded-xl p-6 shadow-sm shadow-black/[0.01] flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center border border-blue-100 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kode Akses Kelas</p>
                <p class="font-mono text-2xl font-bold text-blue-600 tracking-widest mt-0.5">{{ $kelas->kode_kelas }}</p>
            </div>
        </div>
        <button onclick="navigator.clipboard.writeText('{{ $kelas->kode_kelas }}').then(() => alert('Kode berhasil disalin!'))"
                class="bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs px-4 py-2 rounded-xl border border-gray-200 transition duration-150 shadow-sm shadow-black/[0.02] flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 4h6m-6 4h6m-6 4h4"/></svg>
            Salin Kode
        </button>
    </div>
</x-admin-layout>