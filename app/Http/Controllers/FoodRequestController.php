<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FoodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penerima.pengajuan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // (optional) kalau kamu mau validasi penerima harus approved sebelum submit, double safety
        $status = $user?->latestRecipientVerification?->verification_status ?? 'pending';
        if ($status !== 'approved') {
            return back()->with('failed', 'Kamu harus verifikasi dulu sampai disetujui sebelum mengajukan bantuan.');
        }

        $validated = $request->validate([
            'request_for' => 'required|in:self,other',
            'category' => 'required|string|max:255',

            'dependents' => 'nullable|integer|min:0',
            'address_detail' => 'required|string',
            'reason' => 'required|string',
            'main_needs' => 'required|string|max:255',
            'description' => 'nullable|string',

            'recipient_name' => 'nullable|string|max:255',
            'recipient_phone' => 'nullable|string|max:30',
            'relationship' => 'nullable|string|max:255',

            'file_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // wajib isi data penerima kalau request_for = other
        if ($validated['request_for'] === 'other') {
            $request->validate([
                'recipient_name' => 'required|string|max:255',
                'recipient_phone' => 'required|string|max:30',
                'relationship' => 'required|string|max:255',
            ]);
        } else {
            // kalau self, kosongkan field other biar bersih
            $validated['recipient_name'] = null;
            $validated['recipient_phone'] = null;
            $validated['relationship'] = null;
        }

        try {
            // simpan file
            $path = $request->file('file_path')->store("food_requests/{$user->id}", 'public');

            $foodRequest = FoodRequest::create([
                'user_id' => $user->id,

                'request_for' => $validated['request_for'],
                'recipient_name' => $validated['recipient_name'],
                'recipient_phone' => $validated['recipient_phone'],
                'relationship' => $validated['relationship'],

                'category' => $validated['category'],
                'dependents' => $validated['dependents'] ?? null,

                'address_detail' => $validated['address_detail'],
                'reason' => $validated['reason'],
                'main_needs' => $validated['main_needs'],
                'description' => $validated['description'] ?? null,

                'file_path' => $path,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu review petugas.');
        } catch (\Throwable $e) {
            Log::error('FoodRequest store failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('failed', 'Terjadi kesalahan saat menyimpan pengajuan. Coba lagi ya.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
