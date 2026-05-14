<x-siswa-layout :kelas="$kelas">
    <x-slot name="title">Presensi</x-slot>

    <div class="max-w-lg mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Presensi Harian</h1>
            <p class="text-gray-500 mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        @if($sudahAbsen)
        <!-- Sudah Absen -->
        <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-8 text-center">
            <div class="text-6xl mb-4">
                @if($sudahAbsen->status == 'hadir') ✅
                @elseif($sudahAbsen->status == 'izin') 📝
                @elseif($sudahAbsen->status == 'sakit') 🤒
                @else ❌
                @endif
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">
                Anda sudah absen hari ini
            </h2>
            <p class="text-gray-500 mb-4">
                Status: <span class="font-semibold text-emerald-600">{{ ucfirst($sudahAbsen->status) }}</span>
            </p>
            <p class="text-sm text-gray-400">
                Waktu absen: {{ $sudahAbsen->waktu_absen?->format('H:i') ?? '-' }} WIB
            </p>
            @if($sudahAbsen->keterangan)
            <p class="text-sm text-gray-500 mt-2">Keterangan: {{ $sudahAbsen->keterangan }}</p>
            @endif
        </div>
        @else
        <!-- Belum Absen -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="text-center mb-6">
                <div class="text-6xl mb-3">📋</div>
                <p class="text-gray-600">Anda belum melakukan presensi hari ini</p>
            </div>

            <form method="POST" action="{{ route('siswa.kelas.absensi.store', $kelas) }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (opsional)</label>
                    <input type="text" name="keterangan"
                           placeholder="Contoh: Izin karena sakit"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500">
                </div>

                <button type="submit"
                        class="w-full bg-emerald-600 text-white py-4 rounded-xl font-semibold text-lg hover:bg-emerald-700 active:scale-95 transition-all shadow-lg shadow-emerald-200">
                    ✅ Tandai Hadir Sekarang
                </button>

                <p class="text-center text-xs text-gray-400 mt-3">
                    Presensi hanya dapat dilakukan sekali per hari
                </p>
            </form>
        </div>
        @endif
    </div>
</x-siswa-layout>