<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PetugasProfile;
use App\Models\Cabang; // kalau ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::with(['petugas', 'petugas.cabang'])
            ->where('role', 'petugas')
            ->latest()
            ->get();

        return view('admin.manajemen-petugas', compact('petugas'));
    }

    public function show(User $user)
    {
        abort_unless($user->role === 'petugas', 404);

        $user->load(['petugas', 'petugas.cabang']);

        return view('admin.manajemen-petugas-detail', compact('user'));
    }

    public function create()
    {
        $cabang = class_exists(Cabang::class)
            ? Cabang::orderBy('name')->get()
            : collect();

        return view('admin.manajemen-petugas-create', compact('cabang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'nik'       => 'required|string|max:30|unique:users,nik',
            'email'     => 'required|email|unique:users,email',
            'no_telp'   => 'required|string|max:20',
            'alamat'    => 'required|string|max:255',
            'cabang_id' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'password'  => 'required|string|min:6',

            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::transaction(function () use ($request, $data) {
            $user = User::create([
                'name'     => $data['name'],
                'nik'      => $data['nik'],
                'email'    => $data['email'],
                'no_telp'  => $data['no_telp'],
                'alamat'   => $data['alamat'],
                'role'     => 'petugas',
                'password' => Hash::make($data['password']),
            ]);

            $filePath = null;
            if ($request->hasFile('photo')) {
                $filePath = $request->file('photo')->store('petugas', 'public');
            }

            PetugasProfile::create([
                'user_id'   => $user->id,
                'file_path' => $filePath,
                'no_telp'   => $data['no_telp'],
                'alamat'    => $data['alamat'],
                'cabang_id' => $data['cabang_id'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        abort_unless($user->role === 'petugas', 404);

        $user->load('petugas');

        $cabang = class_exists(Cabang::class)
            ? Cabang::orderBy('name')->get()
            : collect();

        return view('admin.manajemen-petugas-edit', compact('user', 'cabang'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->role === 'petugas', 404);

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'nik'       => 'required|string|max:30|unique:users,nik,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'no_telp'   => 'required|string|max:20',
            'alamat'    => 'required|string|max:255',
            'cabang_id' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'password'  => 'nullable|string|min:6',

            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::transaction(function () use ($request, $data, $user) {

            $user->update([
                'name'    => $data['name'],
                'nik'     => $data['nik'],
                'email'   => $data['email'],
                'no_telp' => $data['no_telp'],
                'alamat'  => $data['alamat'],
            ]);

            if (!empty($data['password'])) {
                $user->update(['password' => Hash::make($data['password'])]);
            }

            $profile = $user->petugas ?: new PetugasProfile(['user_id' => $user->id]);

            if ($request->hasFile('photo')) {
                if ($profile->file_path && Storage::disk('public')->exists($profile->file_path)) {
                    Storage::disk('public')->delete($profile->file_path);
                }
                $profile->file_path = $request->file('photo')->store('petugas', 'public');
            }

            $profile->no_telp   = $data['no_telp'];
            $profile->alamat    = $data['alamat'];
            $profile->cabang_id = $data['cabang_id'] ?? null;
            $profile->is_active = $request->boolean('is_active');
            $profile->save();
        });

        return redirect()->route('admin.petugas.detail', $user->id)->with('success', 'Data petugas berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->role === 'petugas', 404);

        DB::transaction(function () use ($user) {
            $profile = $user->petugas;

            if ($profile?->file_path && Storage::disk('public')->exists($profile->file_path)) {
                Storage::disk('public')->delete($profile->file_path);
            }

            $profile?->delete();
            $user->delete();
        });

        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil dihapus.');
    }
}
