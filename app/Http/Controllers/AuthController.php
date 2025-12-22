<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try{
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
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        try{
            $validate = $request->validate([
                'nik' => 'required|string|max:20',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            $user = User::where('nik', $validate['nik'])->first();

            if(!$user || !Hash::check($validate['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'nik' => ['Nik Tidak ditemukan atau Password Salah.']
                ]);
            }

            return response()->json([
                'messages','Login Berhasil',
                'user' => $user
            ]);    
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function logout(Request $request)
    {
       if(!Auth::check()){
            return redirect('/login')->withErrors('Anda harus login terlebih dahulu.');
       }

       Auth::logout();

       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect('/login')->with('status', 'Anda telah logout.');
    }
}
