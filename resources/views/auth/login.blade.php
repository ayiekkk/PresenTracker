<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AbsensiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-emerald-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-lg mb-4">
                <span class="text-3xl">📚</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">AbsensiKu</h1>
            <p class="text-gray-500 mt-1">Sistem Absensi Siswa Digital</p>
        </div>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <h2 class="text-xl font-bold text-gray-800 mb-6">Masuk ke Akun</h2>

            {{-- Session Error --}}
            @if(session('status'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="contoh@email.com"
                        class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror
                               rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                               transition">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-indigo-600 hover:text-indigo-800 hover:underline">
                            Lupa password?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full border @error('password') border-red-400 bg-red-50 @else border-gray-300 @enderror
                                   rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                   transition pr-12">
                        {{-- Toggle show/hide password --}}
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center mb-6">
                    <input type="checkbox" id="remember_me" name="remember"
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                               py-3 rounded-xl transition active:scale-95 shadow-md shadow-indigo-200">
                    Masuk
                </button>
            </form>
        </div>

        {{-- Link Register --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                Daftar sekarang
            </a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }
    </script>

</body>
</html>