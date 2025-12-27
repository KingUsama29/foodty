<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PetugasProfile;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     * Admin melihat semua petugas + profile (cabang, status aktif, dll).
     */
    public function index(Request $request)
    {
        // Query basic: ambil user role petugas + relasi profile & cabang
        $petugas = User::where('role', 'petugas')
            ->with(['petugasProfile.cabang'])
            ->latest('id')
            ->paginate(10);

        // Kalau kamu mau dukung JSON juga (testing Postman / API)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $petugas], 200);
        }

        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     * Form tambah petugas (admin).
     */
    public function create(Request $request)
    {
        // Ambil data cabang buat dropdown
        $cabangs = Cabang::select('id', 'name')->orderBy('name')->get();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['cabangs' => $cabangs], 200);
        }

        return view('admin.petugas.create', compact('cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     * Admin membuat akun petugas (users) + profil petugas (petugas_profiles).
     */
    public function store(Request $request)
    {
        // 1) Validasi input dari form admin
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'nik'       => 'required|string|max:20|unique:users,nik',
            // email boleh nullable kalau kamu mau, tapi kalau wajib ya required
            'email'     => 'nullable|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8',
            'no_telp'   => 'required|string|max:15',
            'alamat'    => 'required|string',
            'cabang_id' => 'required|exists:cabangs,id',
        ]);

        DB::beginTransaction();
        try {
            // 2) Buat user (akun login)
            $user = User::create([
                'name'     => $validated['name'],
                'nik'      => $validated['nik'],
                'email'    => $validated['email'] ?? null,
                'password' => Hash::make($validated['password']),
                'role'     => 'petugas',
            ]);

            // 3) Buat profil petugas (data operasional)
            $profile = PetugasProfile::create([
                'user_id'   => $user->id,
                'no_telp'   => $validated['no_telp'],
                'alamat'    => $validated['alamat'],
                'cabang_id' => $validated['cabang_id'],
                'is_active' => true,
                'file_path' => null, // foto nanti wajib diisi petugas setelah login
            ]);

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Petugas berhasil ditambahkan.',
                    'user' => $user,
                    'profile' => $profile,
                ], 201);
            }

            return redirect()
                ->route('admin.petugas.index')
                ->with('success', 'Petugas berhasil ditambahkan.');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin store petugas failed', [
                'admin_id' => $request->user()->id ?? null,
                'error'    => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat menyimpan data petugas. Coba lagi ya.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->withInput()->with('failed', $failMsg);
        }
    }

    /**
     * Display the specified resource.
     * Detail petugas (admin).
     */
    public function show(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')
            ->with(['petugasProfile.cabang'])
            ->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $petugas], 200);
        }

        return view('admin.petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified resource.
     * Form edit petugas (admin).
     */
    public function edit(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')
            ->with('petugasProfile')
            ->findOrFail($id);

        $cabangs = Cabang::select('id', 'name')->orderBy('name')->get();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'petugas' => $petugas,
                'cabangs' => $cabangs
            ], 200);
        }

        return view('admin.petugas.edit', compact('petugas', 'cabangs'));
    }

    /**
     * Update the specified resource in storage.
     * Admin update data petugas (akun + profil).
     */
    public function update(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        // Pastikan profile ada
        $profile = PetugasProfile::firstOrCreate(
            ['user_id' => $petugas->id],
            [
                'no_telp'   => '',
                'alamat'    => '',
                'cabang_id' => null,
                'is_active' => true,
                'file_path' => null,
            ]
        );

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'nik'       => 'required|string|max:20|unique:users,nik,' . $petugas->id,
            'email'     => 'nullable|email|max:255|unique:users,email,' . $petugas->id,

            // password opsional saat edit; kalau diisi baru diupdate
            'password'  => 'nullable|string|min:8',

            'no_telp'   => 'required|string|max:15',
            'alamat'    => 'required|string',
            'cabang_id' => 'required|exists:cabangs,id',

            // is_active boleh diubah admin
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Update data akun
            $petugas->name  = $validated['name'];
            $petugas->nik   = $validated['nik'];
            $petugas->email = $validated['email'] ?? null;

            if (!empty($validated['password'])) {
                $petugas->password = Hash::make($validated['password']);
            }
            $petugas->save();

            // Update data profil
            $profile->update([
                'no_telp'   => $validated['no_telp'],
                'alamat'    => $validated['alamat'],
                'cabang_id' => $validated['cabang_id'],
                'is_active' => (bool) $validated['is_active'],
            ]);

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Data petugas berhasil diperbarui.',
                    'user' => $petugas->load('petugasProfile.cabang'),
                ], 200);
            }

            return redirect()
                ->route('admin.petugas.index')
                ->with('success', 'Data petugas berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin update petugas failed', [
                'admin_id' => $request->user()->id ?? null,
                'petugas_id' => $petugas->id,
                'error'    => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat update data petugas. Coba lagi ya.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->withInput()->with('failed', $failMsg);
        }
    }

    /**
     * Remove the specified resource from storage.
     * Admin hapus petugas.
     */
    public function destroy(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Karena petugas_profiles pakai cascadeOnDelete, profile ikut kehapus.
            $petugas->delete();

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Petugas berhasil dihapus.'], 200);
            }

            return back()->with('success', 'Petugas berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin delete petugas failed', [
                'admin_id'   => $request->user()->id ?? null,
                'petugas_id' => $petugas->id,
                'error'      => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat menghapus petugas.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->with('failed', $failMsg);
        }
    }

    /**
     * Extra endpoint: toggle aktif/nonaktif petugas (admin).
     * Ini bukan bagian resource default, jadi bikin route PATCH sendiri.
     */
    public function toggleStatus(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $profile = PetugasProfile::where('user_id', $petugas->id)->firstOrFail();

        DB::beginTransaction();
        try {
            // Toggle status
            $profile->is_active = !$profile->is_active;
            $profile->save();

            DB::commit();

            $msg = $profile->is_active ? 'Petugas berhasil diaktifkan.' : 'Petugas berhasil dinonaktifkan.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => $msg,
                    'is_active' => $profile->is_active,
                ], 200);
            }

            return back()->with('success', $msg);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin toggle petugas status failed', [
                'admin_id'   => $request->user()->id ?? null,
                'petugas_id' => $petugas->id,
                'error'      => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat mengubah status petugas.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->with('failed', $failMsg);
        }
    }
}
