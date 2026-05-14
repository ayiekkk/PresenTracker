<x-siswa-layout>
    <x-slot name="title">Cari Kelas</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke Kelas</h1>
            <p class="text-gray-500 mt-1">Masukkan kode kelas yang diberikan guru Anda</p>
        </div>

        <!-- Form Join Kelas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <form method="POST" action="{{ route('siswa.kelas.join') }}">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Kelas</label>
                <div class="flex gap-3">
                    <input type="text" name="kode_kelas" placeholder="Contoh: ABC123"
                           maxlength="6"
                           class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-center font-mono text-xl uppercase tracking-widest focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           oninput="this.value = this.value.toUpperCase()">
                    <button type="submit"
                            class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-emerald-700 transition">
                        Masuk
                    </button>
                </div>
                @error('kode_kelas')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
            </form>
        </div>

        <!-- Kelas yang sudah diikuti -->
        @if($kelasSaya->isNotEmpty())
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Kelas Saya</h2>
            <div class="space-y-3">
                @foreach($kelasSaya as $k)
                <a href="{{ route('siswa.kelas.dashboard', $k) }}"
                   class="flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-emerald-300 hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($k->nama_kelas, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ $k->nama_kelas }}</p>
                        <p class="text-sm text-gray-500">Kelas {{ $k->tingkat }} • {{ $k->jurusan ?? 'Umum' }}</p>
                    </div>
                    <span class="text-gray-400">→</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-siswa-layout>