<x-admin-layout :kelas="$kelas" title="Daftar Siswa">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Siswa</h1>
            <p class="text-gray-500 mt-1">{{ $kelas->nama_kelas }} · {{ $siswa->count() }} siswa</p>
        </div>
        <button onclick="document.getElementById('modalTambahSiswa').showModal()"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition">
            + Tambah Siswa
        </button>
    </div>

    {{-- Tabel Siswa --}}
    @if($siswa->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl border border-gray-100">
        <div class="text-5xl mb-3">👨‍🎓</div>
        <p class="text-gray-500">Belum ada siswa di kelas ini.</p>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">NIS</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($siswa as $i => $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center text-sm font-semibold text-indigo-600">
                                {{ substr($s->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $s->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $s->nis ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $s->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $s->jenis_kelamin == 'L' ? '👦 Laki-laki' : ($s->jenis_kelamin == 'P' ? '👧 Perempuan' : '-') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            {{-- Tombol Edit --}}
                            <button onclick="openEditModal({{ $s->id }}, '{{ addslashes($s->name) }}', '{{ $s->nis }}', '{{ $s->jenis_kelamin }}', '{{ addslashes($s->alamat) }}')"
                                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                                ✏️ Edit
                            </button>
                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.kelas.siswa.destroy', [$kelas, $s]) }}"
                                  onsubmit="return confirm('Keluarkan {{ $s->name }} dari kelas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 border border-red-200 rounded-lg text-sm text-red-500 hover:bg-red-50 transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Modal Tambah Siswa --}}
    <dialog id="modalTambahSiswa" class="rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-black/50">
        <div class="p-6">
            <h3 class="text-lg font-bold mb-4">Tambah Siswa Baru</h3>
            <form method="POST" action="{{ route('admin.kelas.siswa.store', $kelas) }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                        <input type="text" name="nis"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required minlength="6"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahSiswa').close()"
                            class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Tambah Siswa
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modal Edit Siswa --}}
    <dialog id="modalEditSiswa" class="rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-black/50">
        <div class="p-6">
            <h3 class="text-lg font-bold mb-4">Edit Data Siswa</h3>
            <form method="POST" id="formEditSiswa">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="editNama" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                        <input type="text" name="nis" id="editNis"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="editJK"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="alamat" id="editAlamat" rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modalEditSiswa').close()"
                            class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openEditModal(id, nama, nis, jk, alamat) {
            // Set action form dengan id siswa yang benar
            document.getElementById('formEditSiswa').action =
                '{{ url('admin/kelas/' . $kelas->id . '/siswa') }}/' + id;

            // Isi field dengan data siswa
            document.getElementById('editNama').value = nama;
            document.getElementById('editNis').value = nis;
            document.getElementById('editJK').value = jk;
            document.getElementById('editAlamat').value = alamat;

            document.getElementById('modalEditSiswa').showModal();
        }
    </script>

</x-admin-layout>