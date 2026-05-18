<x-admin-layout :kelas="$kelas" title="Daftar Siswa">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Daftar Siswa</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ $kelas->nama_kelas }} • {{ $siswa->count() }} Siswa Terdaftar</p>
        </div>
        <button onclick="document.getElementById('modalTambahSiswa').showModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08] flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Siswa
        </button>
    </div>

    {{-- Tabel Siswa (Mengikuti Desain "Data Siswa" di Kanan Atas Foto Patokan) --}}
    @if($siswa->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01]">
        <div class="w-12 h-12 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <p class="text-xs font-medium text-gray-400">Belum ada data siswa di kelas ini.</p>
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">L/P</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($siswa as $i => $s)
                    <tr class="hover:bg-gray-50/70 transition duration-150">
                        <td class="px-6 py-3.5 text-xs text-gray-400 font-medium">{{ $i + 1 }}</td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[11px] font-bold border border-blue-100/50 flex-shrink-0">
                                    {{ substr($s->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-semibold text-gray-800 tracking-wide">{{ $s->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-xs text-gray-400 font-medium tracking-wide">{{ $s->nis ?? '-' }}</td>
                        <td class="px-6 py-3.5 text-xs text-gray-500 font-medium">{{ $s->email }}</td>
                        <td class="px-6 py-3.5 text-xs text-gray-500 font-medium">
                            {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : ($s->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                        </td>
                        <td class="px-6 py-3.5 text-right pr-8">
                            <div class="inline-flex items-center gap-2">
                                {{-- Tombol Edit (Gaya minimalist abu-abu seperti tombol bawaan foto) --}}
                                <button onclick="openEditModal({{ $s->id }}, '{{ addslashes($s->name) }}', '{{ $s->nis }}', '{{ $s->jenis_kelamin }}', '{{ addslashes($s->alamat) }}')"
                                        class="bg-white hover:bg-gray-50 text-gray-700 font-bold text-[10px] px-3 py-1 rounded-lg border border-gray-200 transition duration-150 shadow-sm shadow-black/[0.01]">
                                    Edit
                                </button>
                                
                                {{-- Tombol Hapus (Warna merah lembut pudar untuk aksen bahaya) --}}
                                <form method="POST" action="{{ route('admin.kelas.siswa.destroy', [$kelas, $s]) }}"
                                      onsubmit="return confirm('Keluarkan {{ $s->name }} dari kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-white hover:bg-rose-50 text-rose-600 font-bold text-[10px] px-3 py-1 rounded-lg border border-gray-200 hover:border-rose-100 transition duration-150 shadow-sm shadow-black/[0.01]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Modal Tambah Siswa --}}
    <dialog id="modalTambahSiswa" class="rounded-2xl border border-gray-200 shadow-2xl p-0 w-full max-w-md backdrop:bg-gray-900/30">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-3">
                <h3 class="text-sm font-bold text-gray-900">Tambah Siswa Baru</h3>
                <button onclick="document.getElementById('modalTambahSiswa').close()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.kelas.siswa.store', $kelas) }}">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">NIS</label>
                            <input type="text" name="nis"
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" name="password" required minlength="6"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="2"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
                    </div>
                </div>
                
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalTambahSiswa').close()"
                            class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs py-2.5 rounded-xl border border-gray-200 transition duration-150">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08]">
                        Tambah Siswa
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modal Edit Siswa --}}
    <dialog id="modalEditSiswa" class="rounded-2xl border border-gray-200 shadow-2xl p-0 w-full max-w-md backdrop:bg-gray-900/30">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-3">
                <h3 class="text-sm font-bold text-gray-900">Edit Data Siswa</h3>
                <button onclick="document.getElementById('modalEditSiswa').close()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" id="formEditSiswa">
                @csrf @method('PUT')
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" id="editNama" required
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">NIS</label>
                            <input type="text" name="nis" id="editNis"
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="editJK"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Alamat</label>
                        <textarea name="alamat" id="editAlamat" rows="2"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
                    </div>
                </div>
                
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalEditSiswa').close()"
                            class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs py-2.5 rounded-xl border border-gray-200 transition duration-150">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition duration-150 shadow-sm shadow-blue-600/[0.08]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openEditModal(id, nama, nis, jk, alamat) {
            document.getElementById('formEditSiswa').action =
                '{{ url('admin/kelas/' . $kelas->id . '/siswa') }}/' + id;

            document.getElementById('editNama').value = nama;
            document.getElementById('editNis').value = nis;
            document.getElementById('editJK').value = jk;
            document.getElementById('editAlamat').value = alamat;

            document.getElementById('modalEditSiswa').showModal();
        }
    </script>

</x-admin-layout>