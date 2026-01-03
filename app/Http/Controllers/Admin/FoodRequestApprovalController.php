<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FoodRequestApprovalController extends Controller
{
    /**
     * List permintaan (bisa search + filter status).
     * GET /admin/food-requests?q=...&status=pending
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status'); // null = semua

        $requests = FoodRequest::with('user')
            ->when($q, function ($qq) use ($q) {
                $qq->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('nik', 'like', "%$q%");
                })
                ->orWhere('category', 'like', "%$q%")
                ->orWhere('reason', 'like', "%$q%");
            })
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan-admin', compact('requests', 'q', 'status'));
    }


    /**
     * Detail permintaan.
     * GET /admin/food-requests/{id}
     */
    public function show(string $id)
    {
        $foodRequest = FoodRequest::with('user')->findOrFail($id);

        // kalau detail kamu masih pakai blade lama:
        // return view('admin.pengajuan-detail', compact('foodRequest'));

        // atau kalau pakai view food_requests.show, biarin:
        return view('admin.pengajuan-detail', compact('foodRequest'));
    }

    /**
     * Update status jadi approved / rejected.
     * PATCH /admin/food-requests/{id}/status
     */
    public function updateStatus(Request $request, string $id)
    {
        $validate = $request->validate([
            'status' => 'required|in:approved,rejected',
            'reject_reason' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $foodRequest = FoodRequest::lockForUpdate()->findOrFail($id);

            // cegah kalau sudah diproses
            if ($foodRequest->status !== 'pending') {
                DB::rollBack();
                return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
            }

            $foodRequest->status = $validate['status'];

            // kalau tabel punya kolom reject_reason (opsional)
            if ($validate['status'] === 'rejected') {
                if (array_key_exists('reject_reason', $foodRequest->getAttributes())) {
                    $foodRequest->reject_reason = $validate['reject_reason'] ?? null;
                }
            } else {
                if (array_key_exists('reject_reason', $foodRequest->getAttributes())) {
                    $foodRequest->reject_reason = null;
                }
            }

            // kalau kamu punya reviewed_at, ini bagus banget ditambah (opsional)
            if (array_key_exists('reviewed_at', $foodRequest->getAttributes())) {
                $foodRequest->reviewed_at = now();
            }

            $foodRequest->save();

            DB::commit();

            return back()->with('success', 'Status pengajuan berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Food Request status update failed', [
                'admin_id' => optional($request->user())->id,
                'food_request_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat update status. Coba lagi ya.');
        }
    }
}
