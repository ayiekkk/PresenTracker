<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Kelas $kelas)
    {
        $this->authorize('view', $kelas);
        $siswa = $kelas->siswa()->orderBy('name')->get();
        return view('admin.kelas.siswa', compact('kelas', 'siswa'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $this->authorize('update', $kelas);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'password' => 'required|min:6',
        ]);

        $siswa = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        $kelas->siswa()->attach($siswa->id);

        return back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, Kelas $kelas, User $siswa)
    {
        $this->authorize('update', $kelas);
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ]);

        $siswa->update($request->only('name', 'nis', 'jenis_kelamin', 'alamat'));
        return back()->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Kelas $kelas, User $siswa)
    {
        $this->authorize('update', $kelas);
        $kelas->siswa()->detach($siswa->id);
        return back()->with('success', 'Siswa berhasil dihapus dari kelas!');
    }
}