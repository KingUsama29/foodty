<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FoodRequest;
use Illuminate\Http\Request;

class RiwayatPengajuanController extends Controller
{
     public function index(Request $request)
    {
        $q = FoodRequest::query()
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) $q->where('status', $request->status);

        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($sub) use ($s) {
                $sub->where('category', 'like', "%{$s}%")
                    ->orWhere('reason', 'like', "%{$s}%")
                    ->orWhere('main_needs', 'like', "%{$s}%");
            });
        }

        $requests = $q->paginate(8)->withQueryString();
        return view('penerima.riwayat', compact('requests'));
    }

    public function show($id)
    {
        $request = FoodRequest::query()
            ->where('id', $id)
            ->where('user_id', auth()->id()) // ini penting biar aman
            ->firstOrFail();

        // kalau kamu punya tabel approval/log, nanti tinggal load relasinya di sini
        // contoh: ->with(['approvals', 'assignedPetugas'])

        return view('penerima.riwayat_show', compact('request'));
    }
}
