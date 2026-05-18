@props(['kelas' => null, 'title' => 'Siswa'])
@php
    // Jika $kelas tidak dikirim oleh controller, ambil langsung dari parameter URL rute
    $kelas = $kelas ?? request()->route('kelas');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - AbsensiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50/50 font-sans antialiased text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR (Clean & Modern Design) ===== --}}
    <aside class="w-64 bg-white border-r border-gray-200/80 flex flex-col fixed h-full z-20">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-sm font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span class="w-2 h-4 bg-emerald-600 rounded-sm inline-block"></span>
                AbsensiKu
            </h1>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Portal Siswa</p>
        </div>

        {{-- Menu Navigasi Dinamis --}}
        @if($kelas)
            <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3 px-3 truncate">
                    {{ $kelas->nama_kelas }}
                </p>

                <a href="{{ route('siswa.kelas.dashboard', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition duration-150 text-[11px] font-bold uppercase tracking-wider
                   {{ request()->routeIs('siswa.kelas.dashboard') ? 'bg-gray-50 text-emerald-600 border border-gray-100' : 'text-gray-500 hover:bg-gray-50/60 hover:text-gray-800' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('siswa.kelas.absensi.index', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition duration-150 text-[11px] font-bold uppercase tracking-wider
                   {{ request()->routeIs('siswa.kelas.absensi.*') ? 'bg-gray-50 text-emerald-600 border border-gray-100' : 'text-gray-500 hover:bg-gray-50/60 hover:text-gray-800' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-12 7h.01M9 16h.01M5 12h.01M5 16h.01"/></svg>
                    Presensi
                </a>

                <a href="{{ route('siswa.kelas.siswa', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition duration-150 text-[11px] font-bold uppercase tracking-wider
                   {{ request()->routeIs('siswa.kelas.siswa') ? 'bg-gray-50 text-emerald-600 border border-gray-100' : 'text-gray-500 hover:bg-gray-50/60 hover:text-gray-800' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Daftar Siswa
                </a>

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ route('siswa.kelas.cari') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[11px] font-bold uppercase tracking-wider text-gray-400 hover:bg-gray-50/60 hover:text-gray-700 transition duration-150">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
                        Kelas Saya
                    </a>
                </div>
            </nav>

        @else
            {{-- Navigasi Utama Saat Berada Di Luar Kelas --}}
            <nav class="flex-1 px-4 py-5 space-y-1">
                <a href="{{ route('siswa.kelas.cari') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[11px] font-bold uppercase tracking-wider bg-gray-50 text-emerald-600 border border-gray-100">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Kelas
                </a>
            </nav>
        @endif

        {{-- Informasi Siswa & Logout --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50/30">
            <p class="text-xs font-bold text-gray-800 truncate px-2" title="{{ auth()->user()->name }}">
                {{ auth()->user()->name }}
            </p>
            <p class="text-[10px] font-medium text-gray-400 px-2 mt-0.5">NIS: {{ auth()->user()->nis ?? '-' }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 uppercase tracking-wider px-2 py-1 block transition duration-150">
                    Logout &rarr;
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== AREA KONTEN UTAMA ===== --}}
    <main class="flex-1 ml-64 overflow-y-auto">
        <div class="p-8 max-w-7xl mx-auto">

            {{-- Notifikasi Sukses Minimalis --}}
            @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-2.5 shadow-sm shadow-emerald-700/[0.01]">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 011-18 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            {{-- Notifikasi Error Minimalis --}}
            @if(session('error'))
            <div class="mb-5 bg-rose-50 border border-rose-100 text-rose-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-2.5 shadow-sm shadow-rose-700/[0.01]">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 011-18 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            {{-- Komponen Konten Halaman --}}
            {{ $slot }}

        </div>
    </main>

</div>

</body>
</html>