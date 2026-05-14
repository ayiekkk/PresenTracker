<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Akun</h2>
        </div>

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Daftar sebagai</label>
            <select name="role" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin/Guru</option>
            </select>
        </div>

        <!-- NIS (khusus siswa) -->
        <div class="mb-4" id="nis-field">
            <label class="block text-sm font-medium text-gray-700">NIS (Nomor Induk Siswa)</label>
            <input type="text" name="nis" value="{{ old('nis') }}"
                   class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
            Daftar
        </button>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
        </p>
    </form>

    <script>
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            document.getElementById('nis-field').style.display = this.value === 'siswa' ? 'block' : 'none';
        });
    </script>
</x-guest-layout>