<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\RecipientVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenerimaManageController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $status = $request->get('status'); // pending/rejected/approved/null

        $verifications = RecipientVerification::with('user')
            ->when($q, function ($query) use ($q) {
                $query->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('verification_status', $status);
            })
            // default: pending dulu baru sisanya
            ->orderByRaw("FIELD(verification_status, 'pending', 'rejected', 'approved')")
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.management-penerima', compact('verifications', 'q', 'status'));
    }


    public function show(RecipientVerification $verification)
    {
        $verification->load(['user', 'documents']);
        return view('petugas.management-penerima-detail', compact('verification'));
    }

    public function approve(RecipientVerification $verification)
    {
        if ($verification->verification_status !== 'pending') {
            return back()->with('error', 'Status sudah diputuskan, tidak bisa diubah.');
        }

        $verification->update([
            'verification_status' => 'approved',
            'verified_at' => now(),      // boleh dipakai sebagai “disetujui pada”
            'reviewed_at' => now(),      // kolom baru (attempt system)
            'cooldown_until' => null,
            'rejected_reason' => null,
        ]);

        return back()->with('success', 'Pengajuan penerima berhasil di-ACC.');
    }


    public function reject(Request $request, RecipientVerification $verification)
    {
        if ($verification->verification_status !== 'pending') {
            return back()->with('error', 'Status sudah diputuskan, tidak bisa diubah.');
        }

        $request->validate([
            'rejected_reason' => 'required|string|min:5|max:255',
        ]);

        $verification->update([
            'verification_status' => 'rejected',
            'rejected_reason' => $request->rejected_reason,
            'reviewed_at' => now(),
            'cooldown_until' => now()->addHours(24), // bisa kamu ganti addDays(1)
            // verified_at bebas: mau now() atau null.
            // kalau kamu pakai verified_at sebagai “tanggal diputuskan”, set now():
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan penerima berhasil ditolak.');
    }

}
