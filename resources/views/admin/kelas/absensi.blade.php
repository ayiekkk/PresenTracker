<x-admin-layout :kelas="$kelas">
    <x-slot name="title">Kelola Absensi</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Absensi</h1>
            <p class="text-gray-500 mt-1">Kelola kehadiran siswa secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-green-600 bg-green-50 px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Live Update
            </div>
            <input type="date" id="tanggalFilter" value="{{ $tanggal }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm"
                   onchange="filterTanggal(this.value)">
        </div>
    </div>

    <!-- Tabel Absensi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">NIS</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Waktu Absen</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Keterangan</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="absensiTable" class="divide-y divide-gray-100">
                    @foreach($siswaDiKelas as $i => $siswa)
                    @php $absen = $absensiHari[$siswa->id] ?? null; @endphp
                    <tr class="hover:bg-gray-50 transition" id="row-{{ $siswa->id }}">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-sm font-medium text-indigo-600">
                                    {{ substr($siswa->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $siswa->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $siswa->nis ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $absen ? $absen->waktu_absen?->format('H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $statusColor = match($absen?->status) {
                                'hadir' => 'bg-green-100 text-green-700',
                                'izin' => 'bg-blue-100 text-blue-700',
                                'sakit' => 'bg-yellow-100 text-yellow-700',
                                'alpha' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-500',
                            };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ ucfirst($absen?->status ?? 'Belum') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $absen?->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.kelas.absensi.store', $kelas) }}"
                                  class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                <select name="status"
                                        class="border border-gray-200 rounded-lg px-2 py-1.5 text-sm focus:ring-2 focus:ring-indigo-500">
                                    <option value="hadir" {{ $absen?->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                    <option value="izin" {{ $absen?->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                    <option value="sakit" {{ $absen?->status == 'sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                                    <option value="alpha" {{ $absen?->status == 'alpha' ? 'selected' : '' }}>❌ Alpha</option>
                                </select>
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-indigo-700 transition">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterTanggal(val) {
            window.location.href = '?tanggal=' + val;
        }

        // Auto-refresh setiap 15 detik untuk live update
        setInterval(() => {
            const tanggal = document.getElementById('tanggalFilter').value;
            fetch('{{ route('admin.kelas.absensi.data', $kelas) }}?tanggal=' + tanggal)
                .then(res => res.json())
                .then(data => {
                    // Update waktu absen & status pada baris yang sudah ada
                    data.forEach(item => {
                        const row = document.getElementById('row-' + item.siswa_id);
                        if (row) {
                            // Update waktu
                            const waktucell = row.cells[3];
                            if (item.waktu_absen) {
                                waktucell.textContent = new Date(item.waktu_absen).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
                            }
                        }
                    });
                });
        }, 15000);
    </script>
</x-admin-layout>