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
     * List permintaan (bisa filter status).
     * GET /admin/food-requests?status=pending
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $foodRequests = FoodRequest::with('user')
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.food_requests.index', compact('foodRequests', 'status'));
    }

    /**
     * Detail permintaan.
     * GET /admin/food-requests/{id}
     */
    public function show(string $id)
    {
        $foodRequest = FoodRequest::with('user')->findOrFail($id);

        return view('admin.food_requests.show', compact('foodRequest'));
    }

    /**
     * Update status jadi approved / rejected.
     * PATCH /admin/food-requests/{id}/status
     */
    public function updateStatus(Request $request, string $id)
    {
        $validate = $request->validate([
            'status' => 'required|in:approved,rejected',
            // optional, kalau kamu punya kolom alasan penolakan
            'reject_reason' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $foodRequest = FoodRequest::lockForUpdate()->findOrFail($id);

            // optional: cegah kalau sudah diproses
            if ($foodRequest->status !== 'pending') {
                return back()->with('failed', 'Permintaan ini sudah diproses sebelumnya.');
            }

            $foodRequest->status = $validate['status'];

            // Kalau kamu punya kolom reject_reason di tabel food_requests:
            if ($validate['status'] === 'rejected') {
                $foodRequest->reject_reason = $validate['reject_reason'] ?? null;
            } else {
                // kalau approve, kosongin alasan
                if (isset($foodRequest->reject_reason)) {
                    $foodRequest->reject_reason = null;
                }
            }

            // Optional: simpan siapa admin yang memproses (kalau ada kolomnya)
            // $foodRequest->approved_by = $request->user()->id;

            $foodRequest->save();

            DB::commit();

            return back()->with('success', 'Status permintaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Food Request status update failed', [
                'admin_id' => $request->user()->id,
                'food_request_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('failed', 'Terjadi kesalahan saat update status. Coba lagi ya.');
        }
    }
}
