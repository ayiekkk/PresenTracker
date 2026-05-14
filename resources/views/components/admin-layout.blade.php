@props(['kelas' => null, 'title' => 'Admin'])

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
    <aside class="w-64 bg-indigo-900 text-white flex flex-col fixed h-full z-10">

        {{-- Logo --}}
        <div class="p-5 border-b border-indigo-700">
            <h1 class="text-xl font-bold">📚 AbsensiKu</h1>
            <p class="text-xs text-indigo-300 mt-1">Panel Admin</p>
        </div>

        {{-- Menu - tampil beda tergantung ada $kelas atau tidak --}}
        @if($kelas)
            <nav class="flex-1 p-4 space-y-1">
                <p class="text-xs text-indigo-400 uppercase font-semibold mb-3 px-3">
                    {{ $kelas->nama_kelas }}
                </p>

                <a href="{{ route('admin.kelas.dashboard', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('admin.kelas.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-800' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('admin.kelas.siswa.index', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('admin.kelas.siswa.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-800' }}">
                    👨‍🎓 Daftar Siswa
                </a>

                <a href="{{ route('admin.kelas.absensi.index', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('admin.kelas.absensi.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-800' }}">
                    ✅ Kelola Absen
                </a>

                <a href="{{ route('admin.kelas.history.index', $kelas) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs('admin.kelas.history.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-800' }}">
                    📋 History
                </a>

                <div class="pt-4 mt-4 border-t border-indigo-700">
                    <a href="{{ route('admin.kelas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-indigo-200 hover:bg-indigo-800 transition">
                        ↩️ Semua Kelas
                    </a>
                </div>
            </nav>

        @else
            {{-- Sidebar saat di halaman daftar kelas (belum masuk kelas tertentu) --}}
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.kelas.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-700 text-white">
                    🏫 Daftar Kelas
                </a>
            </nav>
        @endif

        {{-- Info user + logout --}}
        <div class="p-4 border-t border-indigo-700">
            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="text-xs text-indigo-300 hover:text-white transition">
                    Logout →
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main class="flex-1 ml-64 overflow-y-auto">
        <div class="p-8">

            {{-- Flash message sukses --}}
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg">
                ✅ {{ session('success') }}
            </div>
            @endif

            {{-- Flash message error --}}
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg">
                ❌ {{ session('error') }}
            </div>
            @endif

            {{-- Konten halaman disisipkan di sini --}}
            {{ $slot }}

        </div>
    </main>

</div>

</body>
</html>