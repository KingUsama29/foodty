<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $donors = Donor::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.donatur', compact('donors', 'q'));
    }

    public function create()
    {
        return view('petugas.donatur-form', [
            'donor' => new Donor(),
            'mode' => 'create'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:individu,komunitas,instansi',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        Donor::create($data);

        return redirect()->route('petugas.data-donatur')->with('success', 'Donatur berhasil ditambahkan.');
    }

    public function edit(Donor $donor)
    {
        return view('petugas.donatur-form', [
            'donor' => $donor,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, Donor $donor)
    {
        $data = $request->validate([
            'type' => 'required|in:personal,instansi',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        $donor->update($data);

        return redirect()->route('petugas.data-donatur')->with('success', 'Donatur berhasil diperbarui.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return back()->with('success', 'Donatur berhasil dihapus.');
    }
    
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 2) return response()->json([]);

        $donors = \App\Models\Donor::query()
            ->where('name', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id','name','phone','type']);

        return response()->json($donors);
    }

}
