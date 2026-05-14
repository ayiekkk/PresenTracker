@props(['kelas' => null, 'title' => 'Siswa'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - AbsensiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 bg-emerald-900 text-white flex flex-col fixed h-full z-10">

        {{-- Logo --}}
        <div class="p-5 border-b border-emerald-700">
            <h1 class="text-xl font-bold">📚 AbsensiKu</h1>
            <p class="text-xs text-emerald-300 mt-1">Portal Siswa</p>
        </div>

        @if($kelas)
            <nav class="flex-1 p-4 space-y-1">
                <p class="text-xs text-emerald-400 uppercase font-semibold mb-3 px-3">
                    {{ $kelas->nama_kelas }}
                </p>

                <a href="{{ route('siswa.kelas.dashboard', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('siswa.kelas.dashboard') ? 'bg-emerald-700 text-white' : 'text-emerald-200 hover:bg-emerald-800' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('siswa.kelas.absensi.index', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('siswa.kelas.absensi.*') ? 'bg-emerald-700 text-white' : 'text-emerald-200 hover:bg-emerald-800' }}">
                    ✅ Presensi
                </a>

                <a href="{{ route('siswa.kelas.siswa', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('siswa.kelas.siswa') ? 'bg-emerald-700 text-white' : 'text-emerald-200 hover:bg-emerald-800' }}">
                    👨‍🎓 Daftar Siswa
                </a>

                <div class="pt-4 mt-4 border-t border-emerald-700">
                    <a href="{{ route('siswa.kelas.cari') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-200 hover:bg-emerald-800 transition">
                        ↩️ Kelas Saya
                    </a>
                </div>
            </nav>

        @else
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('siswa.kelas.cari') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-emerald-700 text-white">
                    🔍 Cari Kelas
                </a>
            </nav>
        @endif

        <div class="p-4 border-t border-emerald-700">
            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
            <p class="text-xs text-emerald-300">NIS: {{ auth()->user()->nis ?? '-' }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="text-xs text-emerald-300 hover:text-white transition">
                    Logout →
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main class="flex-1 ml-64 overflow-y-auto">
        <div class="p-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg">
                ❌ {{ session('error') }}
            </div>
            @endif

            {{ $slot }}

        </div>
    </main>

</div>

</body>
</html>