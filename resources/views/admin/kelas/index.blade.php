<x-admin-layout>
    <x-slot name="title">Daftar Kelas</x-slot>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Kelas</h1>
            <p class="text-gray-500 mt-1">Kelola semua kelas Anda</p>
        </div>
        <button onclick="document.getElementById('modalTambahKelas').showModal()"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center gap-2">
            <span>+</span> Tambah Kelas
        </button>
    </div>

    <!-- Grid Kelas -->
    @if($kelas->isEmpty())
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🏫</div>
        <p class="text-gray-500">Belum ada kelas. Buat kelas pertama Anda!</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kelas as $k)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 overflow-hidden">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold">{{ $k->nama_kelas }}</h3>
                        <p class="text-indigo-200 text-sm mt-1">Kelas {{ $k->tingkat }} - {{ $k->jurusan ?? 'Umum' }}</p>
                    </div>
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">
                        {{ $k->siswa_count }} siswa
                    </span>
                </div>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Kode Kelas</p>
                        <p class="font-mono font-bold text-lg text-indigo-600 tracking-widest">{{ $k->kode_kelas }}</p>
                    </div>
                    <button onclick="copyKode('{{ $k->kode_kelas }}')"
                            class="text-xs text-gray-400 hover:text-indigo-600 border border-gray-200 px-2 py-1 rounded">
                        📋 Copy
                    </button>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.kelas.dashboard', $k) }}"
                       class="flex-1 bg-indigo-600 text-white text-center py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        Buka Kelas
                    </a>
                    <button onclick="editKelas({{ $k->id }}, '{{ $k->nama_kelas }}', '{{ $k->tingkat }}', '{{ $k->jurusan }}')"
                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        ✏️
                    </button>
                    <form method="POST" action="{{ route('admin.kelas.destroy', $k) }}"
                          onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-2 border border-red-200 rounded-lg text-sm text-red-500 hover:bg-red-50 transition">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Modal Tambah Kelas -->
    <dialog id="modalTambahKelas" class="rounded-2xl shadow-2xl p-0 w-full max-w-md backdrop:bg-black/50">
        <div class="p-6">
            <h3 class="text-lg font-bold mb-4">Tambah Kelas Baru</h3>
            <form method="POST" action="{{ route('admin.kelas.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas" placeholder="Contoh: XI IPA 1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                    <select name="tingkat" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="X">X (Sepuluh)</option>
                        <option value="XI">XI (Sebelas)</option>
                        <option value="XII">XII (Dua Belas)</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan (opsional)</label>
                    <input type="text" name="jurusan" placeholder="Contoh: IPA, IPS, RPL"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahKelas').close()"
                            class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Buat Kelas
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function copyKode(kode) {
            navigator.clipboard.writeText(kode).then(() => alert('Kode ' + kode + ' disalin!'));
        }
        function editKelas(id, nama, tingkat, jurusan) {
            // Implementasi modal edit
        }
    </script>
</x-admin-layout>