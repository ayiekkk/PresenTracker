<x-siswa-layout>
    <x-slot name="title">Cari Kelas</x-slot>

    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-gray-900">Masuk ke Kelas</h1>
            <p class="text-xs text-gray-400 mt-0.5">Masukkan kode unik kelas yang diberikan oleh guru Anda</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] p-6 mb-8">
            <form method="POST" action="{{ route('siswa.kelas.join') }}">
                @csrf
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Kode Kelas</label>
                <div class="flex gap-2.5">
                    <input type="text" name="kode_kelas" placeholder="ABC123"
                           maxlength="6"
                           required
                           class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-center font-mono text-base font-bold uppercase tracking-widest text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-150"
                           oninput="this.value = this.value.toUpperCase()">
                    
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08] flex items-center justify-center">
                        Masuk
                    </button>
                </div>
                @error('kode_kelas')
                    <p class="text-rose-500 text-[11px] font-medium mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 011-18 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </form>
        </div>

        @if($kelasSaya->isNotEmpty())
        <div>
            <h2 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Kelas Yang Saya Ikuti</h2>
            <div class="space-y-2.5">
                @foreach($kelasSaya as $k)
                <a href="{{ route('siswa.kelas.dashboard', $k) }}"
                   class="flex items-center gap-3 bg-white rounded-xl p-3.5 border border-gray-200/80 shadow-sm shadow-black/[0.01] hover:border-blue-500/50 hover:shadow-md transition-all duration-150 group">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl flex items-center justify-center font-bold text-sm tracking-wide shrink-0">
                        {{ substr($k->nama_kelas, 0, 1) }}
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-800 truncate tracking-wide">{{ $k->nama_kelas }}</p>
                        <p class="text-[10px] font-medium text-gray-400 mt-0.5 truncate">Kelas {{ $k->tingkat }} • {{ $k->jurusan ?? 'Umum' }}</p>
                    </div>
                    
                    <div class="text-gray-300 group-hover:text-blue-500 group-hover:translate-x-0.5 transition duration-150 shrink-0 pr-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-siswa-layout>