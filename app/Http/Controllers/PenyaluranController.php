<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $q = trim((string) $request->get('q', ''));

        // ambil semua penyaluran yg request-nya milik user ini
        $list = Distribution::with(['cabang', 'distributor', 'items.warehouseItem', 'request'])
            ->whereHas('request', fn($r) => $r->where('user_id', $userId))
            ->when($q, function ($qr) use ($q) {
                $qr->where('id', $q)
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhereHas('cabang', fn($c) => $c->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('distributor', fn($u) => $u->where('name', 'like', "%{$q}%"));
            })
            ->latest('distributed_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('penerima.penyaluran', compact('list', 'q'));
    }

    public function show(Distribution $distribution)
    {
        $distribution->load(['request', 'cabang', 'distributor', 'items.warehouseItem']);

        // tameng: penerima hanya boleh lihat miliknya
        abort_if(($distribution->request?->user_id ?? null) !== auth()->id(), 403);

        return view('penerima.penyaluran-show', compact('distribution'));
    }
}
