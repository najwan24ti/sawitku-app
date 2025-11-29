<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. TAMPILKAN SEMUA USER
    public function index()
    {
        $users = User::all();
        // Pastikan Anda sudah punya file view di: resources/views/pages/admin/users/index.blade.php
        return view('pages.admin.users.index', compact('users'));
    }

    // 2. HALAMAN TAMBAH USER
    public function create()
    {
        return view('pages.admin.users.create');
    }

    // 3. SIMPAN USER BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,petani,mitra',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    // 4. HALAMAN EDIT USER
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.users.edit', compact('user'));
    }

    // 5. UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,petani,mitra',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only(['name', 'email', 'role', 'status']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diupdate');
    }

    // 6. HAPUS USER
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.users.index')->with('success', 'User dihapus');
    }
}