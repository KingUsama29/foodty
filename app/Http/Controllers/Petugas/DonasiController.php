<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $donations = Donation::with(['donor'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('donor', function ($d) use ($q) {
                    $d->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->latest('donated_at')
            ->paginate(10)
            ->withQueryString();

        return view('petugas/donasi', compact('donations', 'q'));
    }

    public function create()
    {
        // untuk dropdown donor (nama + phone)
        $donors = Donor::orderBy('name')->get();

        return view('petugas/donasi-form', compact('donors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'donated_at' => 'nullable|date',
            'note' => 'nullable|string|max:500',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // items (array)
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.category' => 'required|in:pangan_kemasan,pangan_segar,non_pangan',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.unit' => 'required|string|max:20',
            'items.*.condition' => 'required|in:baik,rusak_ringan,tidak_layak',
            'items.*.expired_at' => 'nullable|date',
            'items.*.best_before_days' => 'nullable|integer|min:1|max:3650',
            'items.*.note' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $data) {

            $evidencePath = null;
            if ($request->hasFile('evidence')) {
                $evidencePath = $request->file('evidence')->store('donations', 'public');
            }

            // catatan: cabang_id & received_by kamu bisa ambil dari user login
            // kalau user kamu punya cabang_id, pakai itu.
            $cabangId = auth()->user()->cabang_id ?? 1; // kalau belum ada, sementara default 1

            $donation = Donation::create([
                'donor_id' => $data['donor_id'],
                'cabang_id' => $cabangId,
                'received_by' => auth()->id(),
                'donated_at' => $data['donated_at'] ?? now(),
                'status' => 'accepted', // sesuai tabel (draft/accepted/rejected)
                'note' => $data['note'] ?? null,
                'evidence_path' => $evidencePath,
            ]);

            foreach ($data['items'] as $item) {
                $donation->items()->create([
                    'item_name' => $item['item_name'],
                    'category' => $item['category'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'],
                    'condition' => $item['condition'],
                    'expired_at' => $item['expired_at'] ?? null,
                    'best_before_days' => $item['best_before_days'] ?? null,
                    'note' => $item['note'] ?? null,
                ]);
            }
        });

        return redirect()->route('petugas.data-donasi')->with('success', 'Donasi berhasil disimpan.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['donor', 'items', 'receivedBy','cabang']);
        return view('petugas/donasi-detail', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        // hapus evidence kalau ada
        if ($donation->evidence_path) {
            Storage::disk('public')->delete($donation->evidence_path);
        }

        $donation->items()->delete();
        $donation->delete();

        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
}
