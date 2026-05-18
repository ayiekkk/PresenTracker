<x-siswa-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-gray-900 leading-tight">
            {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="mb-5">
            <a href="{{ route('siswa.kelas.dashboard', $kelas->id) }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-600 transition duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm shadow-black/[0.01] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/40">
                            <th class="px-6 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-6 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-40">NIS</th>
                            <th class="px-6 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-48">Jenis Kelamin</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($siswa as $i => $student)
                        <tr class="hover:bg-gray-50/40 transition duration-150">
                            <td class="px-6 py-3.5 text-xs text-gray-400 font-medium text-center">
                                {{ $i + 1 }}
                            </td>

                            <td class="px-6 py-3.5 text-xs font-mono text-gray-500 font-medium tracking-wider">
                                {{ $student->siswa?->nis ?? '-' }}
                            </td>

                            <td class="px-6 py-3.5 text-xs font-bold text-gray-800 tracking-wide">
                                {{ $student->name }}
                            </td>

                            <td class="px-6 py-3.5 text-xs text-gray-400 font-medium">
                                {{ $student->siswa?->jenis_kelamin_label ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-10 h-10 bg-gray-50 text-gray-400 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <p class="text-[11px] font-medium text-gray-400">Belum ada siswa yang bergabung di kelas ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-siswa-layout>