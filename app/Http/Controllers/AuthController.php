<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){

    }
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik|max:20',
            'email' => 'required|string|email|unique:users,email|max:255',
            'no_telp' => 'required|string|unique:users,no_telp|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::create([
            'name' => $validate['name'],
            'nik' => $validate['nik'],
            'email' => $validate['email'],
            'no_telp' => $validate['no_telp'],
            'role' => 'penerima',
            'password' => bcrypt($validate['password']),
        ]);

        if($request->expectsJson() || $request->is('api/*')){
            return response()->json(['message' => 'Registrasi Berhasil', 'user' => $user], 201);
        }
        return redirect('/login')->with('success','Registerasi Berhasil Dilakukan, Silahkan Login!');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'nik' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $login = Auth::attempt([
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if(!$login){
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Login gagal'], 422);            
            }

            return back()->withErrors(['login' => 'NIK/Email atau Password Salah'])->withInput();
        }
        if($request->expectsJson() || $request->is('api/*')){
            return response()->json(['message' => 'Login Berhasil!'], 200);
        }

        return redirect('/dashboard')->with('success', 'Login berhasil');
    }

    public function logout(Request $request)
    {
       if(!Auth::check()){
            return redirect('/login')->withErrors('Anda harus login terlebih dahulu.');
       }

       Auth::logout();

       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
