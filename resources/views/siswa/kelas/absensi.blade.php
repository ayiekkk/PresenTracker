<x-siswa-layout :kelas="$kelas">
    <x-slot name="title">Presensi</x-slot>

    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-gray-900">Presensi Harian</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        @if($sudahAbsen)
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] p-6 text-center">
            <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 border transition duration-150
                @if($sudahAbsen->status == 'hadir') bg-emerald-50 text-emerald-600 border-emerald-100
                @elseif($sudahAbsen->status == 'izin') bg-blue-50 text-blue-600 border-blue-100
                @elseif($sudahAbsen->status == 'sakit') bg-amber-50 text-amber-600 border-amber-100
                @else bg-rose-50 text-rose-600 border-rose-100
                @endif">
                
                @if($sudahAbsen->status == 'hadir')
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                @elseif($sudahAbsen->status == 'izin')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @elseif($sudahAbsen->status == 'sakit')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                @endif
            </div>

            <h2 class="text-sm font-bold text-gray-800 tracking-wide mb-1">
                Anda sudah absen hari ini
            </h2>
            
            <div class="text-xs text-gray-400 font-medium space-y-1">
                <p>Status: 
                    <span class="font-bold uppercase tracking-wider text-[10px] px-2 py-0.5 border rounded-md
                        @if($sudahAbsen->status == 'hadir') bg-emerald-50 text-emerald-600 border-emerald-100
                        @elseif($sudahAbsen->status == 'izin') bg-blue-50 text-blue-600 border-blue-100
                        @elseif($sudahAbsen->status == 'sakit') bg-amber-50 text-amber-600 border-amber-100
                        @else bg-rose-50 text-rose-600 border-rose-100
                        @endif">
                        {{ $sudahAbsen->status }}
                    </span>
                </p>
                <p class="pt-2">Waktu absen: <span class="text-gray-600 font-semibold">{{ $sudahAbsen->waktu_absen?->format('H:i') ?? '-' }} WIB</span></p>
            </div>

            @if($sudahAbsen->keterangan)
            <div class="mt-4 pt-3 border-t border-gray-100 text-left">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan</p>
                <p class="text-xs font-medium text-gray-600 bg-gray-50 border border-gray-100 rounded-xl px-3 py-2">{{ $sudahAbsen->keterangan }}</p>
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] p-6">
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <p class="text-xs font-medium text-gray-400">Anda belum melakukan presensi hari ini</p>
            </div>

            <form method="POST" action="{{ route('siswa.kelas.absensi.store', $kelas) }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Keterangan <span class="text-gray-300 font-normal">(Opsional)</span></label>
                    <input type="text" name="keterangan"
                           placeholder="Contoh: Hadir tepat waktu / Izin"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                </div>

                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-xl transition duration-150 shadow-sm shadow-emerald-600/[0.08] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Tandai Hadir Sekarang
                </button>

                <p class="text-center text-[10px] font-medium text-gray-400 mt-3.5">
                    Catatan: Presensi hanya dapat dilakukan sekali setiap hari.
                </p>
            </form>
        </div>
        @endif
    </div>
</x-siswa-layout>