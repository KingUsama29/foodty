<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     * Admin melihat daftar cabang.
     */
    public function index(Request $request)
    {
        $cabangs = Cabang::latest('id')->paginate(10);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $cabangs], 200);
        }

        return view('admin.cabang.index', compact('cabangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'OK'], 200);
        }

        return view('admin.cabang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255|unique:cabangs,name',
            'alamat' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $cabang = Cabang::create([
                'name'      => $validated['name'],
                'alamat'    => $validated['alamat'] ?? null,
                'is_active' => true,
            ]);

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Cabang berhasil ditambahkan.',
                    'cabang'  => $cabang,
                ], 201);
            }

            return redirect()
                ->route('admin.cabang.index')
                ->with('success', 'Cabang berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin store cabang failed', [
                'admin_id' => $request->user()->id ?? null,
                'error'    => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat menyimpan data cabang. Coba lagi ya.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->withInput()->with('failed', $failMsg);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $cabang = Cabang::findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $cabang], 200);
        }

        return view('admin.cabang.show', compact('cabang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $cabang = Cabang::findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $cabang], 200);
        }

        return view('admin.cabang.edit', compact('cabang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cabang = Cabang::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:cabangs,name,' . $cabang->id,
            'alamat'    => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $cabang->update([
                'name'      => $validated['name'],
                'alamat'    => $validated['alamat'] ?? null,
                'is_active' => (bool) $validated['is_active'],
            ]);

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Cabang berhasil diperbarui.',
                    'cabang'  => $cabang,
                ], 200);
            }

            return redirect()
                ->route('admin.cabang.index')
                ->with('success', 'Cabang berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin update cabang failed', [
                'admin_id'  => $request->user()->id ?? null,
                'cabang_id' => $cabang->id,
                'error'     => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat update data cabang. Coba lagi ya.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->withInput()->with('failed', $failMsg);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $cabang = Cabang::findOrFail($id);

        DB::beginTransaction();
        try {
            // Karena petugas_profiles.cabang_id pakai nullOnDelete,
            // maka saat cabang dihapus, cabang_id di petugas_profiles otomatis jadi NULL.
            $cabang->delete();

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Cabang berhasil dihapus.'], 200);
            }

            return back()->with('success', 'Cabang berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin delete cabang failed', [
                'admin_id'  => $request->user()->id ?? null,
                'cabang_id' => $cabang->id,
                'error'     => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat menghapus cabang.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->with('failed', $failMsg);
        }
    }

    /**
     * Extra endpoint: toggle aktif/nonaktif cabang (admin).
     * Bikin route PATCH sendiri.
     */
    public function toggleStatus(Request $request, string $id)
    {
        $cabang = Cabang::findOrFail($id);

        DB::beginTransaction();
        try {
            $cabang->is_active = !$cabang->is_active;
            $cabang->save();

            DB::commit();

            $msg = $cabang->is_active ? 'Cabang berhasil diaktifkan.' : 'Cabang berhasil dinonaktifkan.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message'   => $msg,
                    'is_active' => $cabang->is_active,
                ], 200);
            }

            return back()->with('success', $msg);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Admin toggle cabang status failed', [
                'admin_id'  => $request->user()->id ?? null,
                'cabang_id' => $cabang->id,
                'error'     => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat mengubah status cabang.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            return back()->with('failed', $failMsg);
        }
    }
}
