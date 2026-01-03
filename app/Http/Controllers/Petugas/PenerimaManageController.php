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

        $verifications = RecipientVerification::with('user')
            ->when($q, function ($query) use ($q) {
                $query->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                      ->orWhere('nik', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByRaw("FIELD(verification_status, 'pending', 'rejected', 'approved')")
            ->latest()
            ->paginate(10);

        return view('petugas.management-penerima', compact('verifications', 'q'));
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
            'verified_at' => Carbon::now(),
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
            'verified_at' => null,
            'rejected_reason' => $request->rejected_reason,
        ]);

        return back()->with('success', 'Pengajuan penerima berhasil ditolak.');
    }
}
