<x-admin-layout>
    <x-slot name="title">Daftar Kelas</x-slot>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Daftar Kelas</h1>
            <p class="text-xs text-gray-400 mt-0.5">Kelola dan pantau semua kelas Anda</p>
        </div>
        <button onclick="document.getElementById('modalTambahKelas').showModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08] flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kelas
        </button>
    </div>

    @if($kelas->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01]">
        <div class="w-12 h-12 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <p class="text-xs font-medium text-gray-400">Belum ada kelas. Buat kelas pertama Anda!</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kelas as $k)
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] hover:shadow-md hover:border-gray-300/70 transition-all duration-200 overflow-hidden flex flex-col justify-between">
            <div class="p-5 border-b border-gray-100 bg-gray-50/30">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 tracking-wide">{{ $k->nama_kelas }}</h3>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Tingkat {{ $k->tingkat }} • {{ $k->jurusan ?? 'Umum' }}</p>
                    </div>
                    <span class="inline-block bg-blue-50 text-blue-600 border border-blue-100 px-2.5 py-0.5 rounded-md text-[10px] font-bold tracking-wide shrink-0">
                        {{ $k->siswa_count }} SISWA
                    </span>
                </div>
            </div>

            <div class="p-5">
                <div class="flex items-center justify-between mb-5 bg-gray-50 border border-gray-100 rounded-xl px-3 py-2">
                    <div>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Kode Kelas</p>
                        <p class="font-mono font-bold text-sm text-blue-600 tracking-widest mt-0.5">{{ $k->kode_kelas }}</p>
                    </div>
                    <button onclick="copyKode('{{ $k->kode_kelas }}')"
                            class="bg-white hover:bg-gray-50 text-gray-600 font-semibold text-[10px] px-2.5 py-1 rounded-lg border border-gray-200 transition duration-150 flex items-center gap-1">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 00-2 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Salin
                    </button>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.kelas.dashboard', $k) }}"
                       class="flex-1 bg-white hover:bg-gray-50 text-gray-700 text-center font-bold text-xs py-2 rounded-xl border border-gray-200 transition duration-150 shadow-sm shadow-black/[0.01]">
                        Buka Kelas
                    </a>
                    
                    <button onclick="editKelas({{ $k->id }}, '{{ $k->nama_kelas }}', '{{ $k->tingkat }}', '{{ $k->jurusan }}')"
                            class="px-3 py-2 bg-white hover:bg-gray-50 border border-gray-200 text-gray-500 hover:text-gray-700 rounded-xl transition duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </button>
                    
                    <form method="POST" action="{{ route('admin.kelas.destroy', $k) }}"
                          onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-2 bg-white hover:bg-rose-50 border border-gray-200 hover:border-rose-100 text-rose-500 rounded-xl transition duration-150">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <dialog id="modalTambahKelas" class="rounded-2xl border border-gray-200 shadow-2xl p-0 w-full max-w-md backdrop:bg-gray-900/30">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-3">
                <h3 class="text-sm font-bold text-gray-900">Tambah Kelas Baru</h3>
                <button onclick="document.getElementById('modalTambahKelas').close()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.kelas.store') }}">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Kelas</label>
                        <input type="text" name="nama_kelas" placeholder="Contoh: XI IPA 1" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tingkat</label>
                        <select name="tingkat" required 
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="X">X (Sepuluh)</option>
                            <option value="XI">XI (Sebelas)</option>
                            <option value="XII">XII (Dua Belas)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jurusan <span class="text-gray-300 font-normal">(Opsional)</span></label>
                        <input type="text" name="jurusan" placeholder="Contoh: IPA, IPS, RPL"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>
                
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalTambahKelas').close()"
                            class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs py-2.5 rounded-xl border border-gray-200 transition duration-150">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08]">
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
            // Implementasi modal edit menyesuaikan dengan struktur ID form edit Anda
        }
    </script>
</x-admin-layout>