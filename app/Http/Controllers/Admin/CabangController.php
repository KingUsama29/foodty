<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $cabangs = Cabang::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.cabang-lokasi', compact('cabangs', 'q'));
    }

    public function create()
    {
        return view('admin.manajemen-cabang-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'alamat'   => 'required|string|max:255',
            'is_active'=> 'nullable|boolean',
        ]);

        Cabang::create([
            'name'      => $data['name'],
            'alamat'    => $data['alamat'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.cabang')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Cabang $cabang)
    {
        return view('admin.manajemen-cabang-edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'alamat'   => 'required|string|max:255',
            'is_active'=> 'nullable|boolean',
        ]);

        $cabang->update([
            'name'      => $data['name'],
            'alamat'    => $data['alamat'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.cabang')->with('success', 'Cabang berhasil diupdate.');
    }

    public function destroy(Cabang $cabang)
    {
        // kalau cabang dipakai petugas, biasanya ditolak (opsional)
        // if ($cabang->petugasProfiles()->exists()) { ... }

        $cabang->delete();
        return redirect()->route('admin.cabang')->with('success', 'Cabang berhasil dihapus.');
    }

    public function toggleStatus(Cabang $cabang)
    {
        $cabang->update([
            'is_active' => !$cabang->is_active
        ]);

        return back()->with('success', 'Status cabang berhasil diubah.');
    }
}
