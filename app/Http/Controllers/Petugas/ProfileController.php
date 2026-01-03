<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\PetugasProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ambil data petugas, kalau belum ada buat (biar aman)
        $petugas = PetugasProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'no_telp' => $user->no_telp ?? null,
                'alamat' => $user->alamat ?? null,
                'cabang_id' => 1,
                'is_active' => 1,
                'file_path' => null,
            ]
        );

        $petugas->load('user', 'cabang');

        return view('petugas/profil-petugas', compact('user', 'petugas'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'no_telp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB
        ]);

        $petugas = PetugasProfile::firstOrCreate(['user_id' => $user->id]);

        // upload foto kalau ada
        if ($request->hasFile('photo')) {
            // hapus foto lama kalau ada
            if ($petugas->file_path) {
                Storage::disk('public')->delete($petugas->file_path);
            }

            $path = $request->file('photo')->store('petugas_profiles', 'public');
            $petugas->file_path = $path;
        }

        // update data petugas
        $petugas->no_telp = $data['no_telp'] ?? $petugas->no_telp;
        $petugas->alamat  = $data['alamat'] ?? $petugas->alamat;
        $petugas->save();

        // (opsional) kalau mau sinkron juga ke tabel users:
        // $user->update([
        //     'no_telp' => $petugas->no_telp,
        //     'alamat'  => $petugas->alamat,
        // ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = auth()->user();
        $petugas = \App\Models\PetugasProfile::where('user_id', $user->id)->first();

        if (!$petugas) {
            return back()->with('success', 'Foto profil sudah kosong.');
        }

        if ($petugas->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($petugas->file_path);
            $petugas->file_path = null;
            $petugas->save();
        }

        return back()->with('success', 'Foto profil berhasil dihapus (kembali ke default).');
    }

}
