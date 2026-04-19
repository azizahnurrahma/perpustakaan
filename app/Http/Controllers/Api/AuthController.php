<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,mahasiswa',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Pake Hash::make biar aman
            'role' => $request->role,
                'nim' => $request->nim, // Optional, bisa diisi kalau role-nya mahasiswa
                'jurusan' => $request->jurusan, // Optional, bisa diisi kalau role-nya mahasiswa
                'no_telp' => $request->no_telp, 
        ]);

        return response()->json([
            'pesan' => 'Registrasi Berhasil!',
            'user' => $user
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan passwordnya benar
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['pesan' => 'Email atau password salah!'], 401);
        }

        // BUAT TOKEN 
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'pesan' => 'Login Berhasil!',
            'access_token' => $token, // Token ini yang harus disimpan di Postman/Frontend
            'token_type' => 'Bearer',
            'role' => $user->role // Kasih tau role-nya apa (Admin/Mahasiswa)
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();
        return response()->json(['pesan' => 'Berhasil Logout']);
    }
}