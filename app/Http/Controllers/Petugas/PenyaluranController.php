<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\FoodRequest;
use App\Models\WarehouseMovement;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenyaluranController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $list = Distribution::with(['request.user', 'cabang', 'distributor'])
            ->when($q, function ($qr) use ($q) {
                $qr->whereHas('request.user', fn($u) => $u->where('name', 'like', "%{$q}%"))
                    ->orWhere('id', $q);
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.penyaluran', compact('list', 'q'));
    }

    public function create(Request $request)
    {
        $petugasProfile = auth()->user()->petugas;
        $cabangId = $petugasProfile?->cabang_id;

        if (!$cabangId) abort(403, 'Petugas belum memiliki cabang.');

        $requests = FoodRequest::with('user')
            ->where('status', 'approved')
            ->whereDoesntHave('distributions', function ($q) {
                $q->whereIn('status', ['completed']); // kalau canceled boleh dibuat lagi
            })
            ->latest('id')
            ->get();

        $stocks = WarehouseStock::with('warehouseItem')
            ->where('cabang_id', $cabangId)
            ->where('qty', '>', 0)
            ->orderBy('warehouse_item_id')
            ->orderBy('expired_at')
            ->get();

        $selectedRequest = null;
        if ($request->filled('food_request_id')) {
            $selectedRequest = FoodRequest::with('user')
                ->where('status', 'approved')
                ->find($request->food_request_id);
        }

        return view('petugas.penyaluran-create', compact('requests', 'stocks', 'cabangId', 'selectedRequest'));
    }

    private function stockQuery($cabangId, $wid, $expiredAt)
    {
        $q = WarehouseStock::where('cabang_id', $cabangId)
            ->where('warehouse_item_id', $wid);

        if ($expiredAt === null || $expiredAt === '') {
            $q->whereNull('expired_at');
        } else {
            $q->where('expired_at', $expiredAt);
        }

        return $q;
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_request_id' => 'required|exists:food_requests,id',
            'scheduled_at'    => 'required|date', // jadwal pengantaran WAJIB biar jelas untuk penerima
            'note'            => 'nullable|string|max:500',

            'items' => 'required|array|min:1',
            'items.*.warehouse_item_id' => 'required|exists:warehouse_items,id',
            'items.*.expired_at' => 'nullable|date',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.unit' => 'required|string|max:20',
            'items.*.note' => 'nullable|string|max:500',
        ]);

        $petugasProfile = auth()->user()->petugas;
        $cabangId = $petugasProfile?->cabang_id;

        if (!$cabangId) {
            return back()->withInput()->with('error', 'Petugas belum punya cabang.');
        }

        $foodRequest = FoodRequest::with('user')->findOrFail($request->food_request_id);

        if ($foodRequest->status !== 'approved') {
            return back()->withInput()->with('error', 'Food request harus approved untuk bisa disalurkan.');
        }

        $alreadyDistributed = $foodRequest->distributions()
            ->whereIn('status', ['completed'])
            ->exists();

        if ($alreadyDistributed) {
            return back()->withInput()->with('error', 'Pengajuan ini sudah pernah disalurkan, tidak bisa disalurkan lagi.');
        }

        try {
            DB::transaction(function () use ($request, $cabangId, $foodRequest) {

                // ✅ saat dibuat: statusnya DIJADWALKAN, belum selesai disalurkan
                $dist = Distribution::create([
                    'food_request_id' => $foodRequest->id,
                    'cabang_id'       => $cabangId,
                    'distributed_by'  => auth()->id(),

                    'scheduled_at'    => $request->scheduled_at, // jadwal antar
                    'status'          => 'scheduled',

                    // distributed_at = waktu selesai, jadi NULL dulu
                    'distributed_at'  => null,

                    'note'            => $request->note,

                    'recipient_name'    => $foodRequest->user?->name,
                    'recipient_phone'   => $foodRequest->user?->no_telp,
                    'recipient_address' => $foodRequest->address_detail,
                ]);

                foreach ($request->items as $it) {
                    $wid = (int) $it['warehouse_item_id'];
                    $expiredAt = $it['expired_at'] ?? null;
                    $qty = (float) $it['qty'];
                    $unit = strtolower(trim($it['unit']));

                    $stockQ = $this->stockQuery($cabangId, $wid, $expiredAt);
                    $stock = $stockQ->lockForUpdate()->first();

                    if (!$stock) {
                        throw ValidationException::withMessages([
                            "items" => "Stok tidak ditemukan untuk item_id={$wid} (batch/expired tidak sesuai).",
                        ]);
                    }

                    if ((float) $stock->qty < $qty) {
                        $itemName = $stock->warehouseItem->name ?? "item_id={$wid}";
                        throw ValidationException::withMessages([
                            "items" => "Stok tidak cukup untuk {$itemName}. Tersedia {$stock->qty} {$stock->unit}, diminta {$qty}.",
                        ]);
                    }

                    if (strtolower($stock->unit) !== $unit) {
                        throw ValidationException::withMessages([
                            "items" => "Unit tidak cocok. Stok={$stock->unit}, input={$unit}",
                        ]);
                    }

                    $dist->items()->create([
                        'warehouse_item_id' => $wid,
                        'expired_at'        => ($expiredAt === '' ? null : $expiredAt),
                        'qty'               => $qty,
                        'unit'              => $unit,
                        'note'              => $it['note'] ?? null,
                    ]);

                    // ✅ stok langsung berkurang saat dibuat penyaluran (biar stok cabang real-time)
                    $stock->update(['qty' => (float) $stock->qty - $qty]);

                    WarehouseMovement::create([
                        'cabang_id'         => $cabangId,
                        'warehouse_item_id' => $wid,
                        'type'              => 'out',
                        'source_type'       => 'distribution',
                        'source_id'         => $dist->id,
                        'expired_at'        => ($expiredAt === '' ? null : $expiredAt),
                        'qty'               => $qty,
                        'unit'              => $unit,
                        'created_by'        => auth()->id(),
                        'note'              => "Penyaluran (DIJADWALKAN) untuk food_request_id={$foodRequest->id}",
                        'moved_at'          => now(),
                    ]);
                }
            });
        } catch (ValidationException $e) {
            throw $e;
        }

        return redirect()->route('petugas.data-penyaluran')
            ->with('success', 'Penyaluran dibuat. Status: Dijadwalkan. Stok gudang sudah dikurangi.');
    }

    // ✅ tombol "Mulai antar / OTW"
    public function markOnDelivery(Distribution $distribution)
    {
        if (!in_array($distribution->status, ['scheduled'])) {
            return back()->with('error', 'Status harus Dijadwalkan dulu untuk mulai pengantaran.');
        }

        $distribution->update([
            'status' => 'on_delivery',
        ]);

        return back()->with('success', 'Status diubah: Dalam Pengantaran.');
    }

    // ✅ tombol "Selesai disalurkan"
    public function markCompleted(Distribution $distribution)
    {
        if (!in_array($distribution->status, ['scheduled', 'on_delivery'])) {
            return back()->with('error', 'Status harus Dijadwalkan / Dalam Pengantaran dulu.');
        }

        $distribution->update([
            'status'         => 'completed',
            'distributed_at' => now(),
        ]);

        return back()->with('success', 'Status diubah: Sudah Disalurkan.');
    }

    public function show(Distribution $distribution)
    {
        $distribution->load(['request.user', 'cabang', 'distributor', 'items.warehouseItem']);
        return view('petugas.penyaluran-show', compact('distribution'));
    }

    public function cancel(Request $request, Distribution $distribution)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if (!in_array($distribution->status, ['scheduled', 'on_delivery', 'completed'])) {
            return back()->with('error', 'Penyaluran tidak bisa dibatalkan pada status ini.');
        }

        DB::transaction(function () use ($distribution, $request) {
            $distribution->load('items');

            foreach ($distribution->items as $it) {
                $stockQ = $this->stockQuery($distribution->cabang_id, $it->warehouse_item_id, $it->expired_at);
                $stock = $stockQ->lockForUpdate()->first();

                if ($stock) {
                    $stock->update(['qty' => (float) $stock->qty + (float) $it->qty]);
                }

                WarehouseMovement::create([
                    'cabang_id'         => $distribution->cabang_id,
                    'warehouse_item_id' => $it->warehouse_item_id,
                    'type'              => 'in',
                    'source_type'       => 'distribution_cancel',
                    'source_id'         => $distribution->id,
                    'expired_at'        => $it->expired_at,
                    'qty'               => $it->qty,
                    'unit'              => $it->unit,
                    'created_by'        => auth()->id(),
                    'note'              => 'Rollback penyaluran: ' . $request->reason,
                    'moved_at'          => now(),
                ]);
            }

            $distribution->update([
                'status' => 'canceled',
                'note'   => trim(($distribution->note ? $distribution->note . "\n" : '') . 'CANCEL: ' . $request->reason),
            ]);
        });

        return back()->with('success', 'Penyaluran dibatalkan, stok gudang sudah dikembalikan.');
    }

    public function requests(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $requests = \App\Models\FoodRequest::with('user')
            ->where('status', 'approved')
            ->whereDoesntHave('distributions', function ($q) {
                $q->whereIn('status', ['completed']);
            })
            ->when($q, function ($qr) use ($q) {
                $qr->whereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"))
                ->orWhere('id', $q)
                ->orWhere('main_needs', 'like', "%{$q}%")
                ->orWhere('category', 'like', "%{$q}%");
            })
            ->latest('reviewed_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.penyaluran-requests', compact('requests', 'q'));
    }

}
