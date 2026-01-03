<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\FoodRequest;
use Illuminate\Http\Request;

class FoodRequestManageController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $requests = FoodRequest::with('user')
            ->when($q, function ($query) use ($q) {
                $query->where('category', 'like', "%{$q}%")
                      ->orWhere('main_needs', 'like', "%{$q}%")
                      ->orWhere('reason', 'like', "%{$q}%")
                      ->orWhereHas('user', function ($u) use ($q) {
                          $u->where('name', 'like', "%{$q}%")
                            ->orWhere('nik', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                      });
            })
            ->orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.pengajuan', compact('requests', 'q'));
    }

    public function show(FoodRequest $foodRequest)
    {
        $foodRequest->load('user');
        return view('petugas.pengajuan_show', compact('foodRequest'));
    }
}
