<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik|max:20',
            'email' => 'required|string|email|unique:users,email|max:255',
            'no_telp' => 'required|string|unique:users,no_telp|max:15',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::create([
            'name' => $validate['name'],
            'nik' => $validate['nik'],
            'email' => $validate['email'],
            'no_telp' => $validate['no_telp'],
            'alamat' => $validate['alamat'],
            'role' => 'user',
            'password' => bcrypt($validate['password']),
        ]);

        return response()->json(['message'=>'Registrasi Berhasil Dilakukan!', 'user' => $user]);
    }
    public function login(Request $request)
    {
        // Login logic here
    }
    public function logout(Request $request)
    {
        // Logout logic here
    }
}
