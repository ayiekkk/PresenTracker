<x-admin-layout :kelas="$kelas">
    <x-slot name="title">Kelola Absensi</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Kelola Absensi</h1>
            <p class="text-xs text-gray-400 mt-0.5">Kelola kehadiran siswa secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                Live Update
            </div>
            <input type="date" id="tanggalFilter" value="{{ $tanggal }}"
                   class="border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-medium text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   onchange="filterTanggal(this.value)">
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Waktu Absen</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody id="absensiTable" class="divide-y divide-gray-100">
                    @foreach($siswaDiKelas as $i => $siswa)
                    @php $absen = $absensiHari[$siswa->id] ?? null; @endphp
                    <tr class="hover:bg-gray-50/70 transition duration-150" id="row-{{ $siswa->id }}">
                        <td class="px-6 py-3.5 text-xs text-gray-400 font-medium">{{ $i + 1 }}</td>
                        
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[11px] font-bold border border-blue-100/50 flex-shrink-0">
                                    {{ substr($siswa->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-semibold text-gray-800 tracking-wide">{{ $siswa->name }}</span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-3.5 text-xs text-gray-400 font-medium tracking-wide">{{ $siswa->nis ?? '-' }}</td>
                        
                        <td class="px-6 py-3.5 text-xs text-gray-500 font-medium">
                            {{ $absen ? $absen->waktu_absen?->format('H:i') : '-' }}
                        </td>
                        
                        <td class="px-6 py-3.5">
                            @php
                            $statusColor = match($absen?->status) {
                                'hadir' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                'izin' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                'sakit' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                'alpha' => 'bg-red-50 text-red-600 border border-red-100',
                                default => 'bg-gray-50 text-gray-400 border border-gray-200/60',
                            };
                            @endphp
                            <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold tracking-wide {{ $statusColor }}">
                                {{ $absen?->status ? strtoupper($absen->status) : 'BELUM' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-3.5 text-xs text-gray-400 truncate max-w-[150px] font-medium">{{ $absen?->keterangan ?? '-' }}</td>
                        
                        <td class="px-6 py-3.5 text-right pr-8">
                            <form method="POST" action="{{ route('admin.kelas.absensi.store', $kelas) }}"
                                  class="inline-flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                
                                <select name="status"
                                        class="border border-gray-200 bg-white rounded-lg px-2 py-1 text-[11px] font-medium text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="hadir" {{ $absen?->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="izin" {{ $absen?->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="sakit" {{ $absen?->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="alpha" {{ $absen?->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                                </select>
                                
                                <button type="submit"
                                        class="bg-white hover:bg-gray-50 text-gray-700 font-bold text-[10px] px-3 py-1 rounded-lg border border-gray-200 transition duration-150 shadow-sm shadow-black/[0.02]">
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

        setInterval(() => {
            const tanggal = document.getElementById('tanggalFilter').value;
            fetch('{{ route('admin.kelas.absensi.data', $kelas) }}?tanggal=' + tanggal)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        const row = document.getElementById('row-' + item.siswa_id);
                        if (row) {
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