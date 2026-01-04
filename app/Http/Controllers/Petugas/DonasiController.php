<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\WarehouseItem;
use App\Models\WarehouseStock;
use App\Models\WarehouseMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'donor_id' => 'required|exists:donors,id',
            'donated_at' => 'nullable|date',
            'note' => 'nullable|string|max:500',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

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

        // aturan tambahan (biar sesuai real)
        $validator->after(function ($v) use ($request) {
            foreach ($request->input('items', []) as $i => $item) {
                $cat = $item['category'] ?? null;

                if ($cat === 'pangan_kemasan' && empty($item['expired_at'])) {
                    $v->errors()->add("items.$i.expired_at", 'Tanggal kadaluarsa wajib untuk pangan kemasan.');
                }

                if ($cat === 'pangan_segar' && empty($item['expired_at']) && empty($item['best_before_days'])) {
                    $v->errors()->add("items.$i.best_before_days", 'Untuk pangan segar isi expired_at atau best_before_days.');
                }
            }
        });

        $data = $validator->validate();

        DB::transaction(function () use ($request, $data) {

            // 1) Ambil cabang petugas (jangan default 1 diam-diam)
            $petugasProfile = auth()->user()->petugas;
            $cabangId = $petugasProfile?->cabang_id;

            if (!$cabangId) {
                throw new \Exception('Petugas belum memiliki cabang. Silakan set cabang_id di petugas_profiles.');
            }

            // 2) Upload bukti (optional)
            $evidencePath = null;
            if ($request->hasFile('evidence')) {
                $evidencePath = $request->file('evidence')->store('donations', 'public');
            }

            // 3) Create donation (accepted langsung)
            $donation = Donation::create([
                'donor_id' => $data['donor_id'],
                'cabang_id' => $cabangId,
                'received_by' => auth()->id(),
                'donated_at' => $data['donated_at'] ?? now(),
                'status' => 'accepted',
                'note' => $data['note'] ?? null,
                'evidence_path' => $evidencePath,
            ]);

            // 4) Create items + AUTO warehouse
            foreach ($data['items'] as $item) {

                $unit = strtolower(trim($item['unit']));
                $itemName = trim($item['item_name']);

                $donationItem = $donation->items()->create([
                    'item_name' => $itemName,
                    'category' => $item['category'],
                    'qty' => $item['qty'],
                    'unit' => $unit,
                    'condition' => $item['condition'],
                    'expired_at' => $item['expired_at'] ?? null,
                    'best_before_days' => $item['best_before_days'] ?? null,
                    'note' => $item['note'] ?? null,
                ]);

                // Skip kalau tidak layak
                if ($donationItem->condition === 'tidak_layak') {
                    continue;
                }

                // expired batch (pangan segar bisa dari best_before_days)
                $expiredAt = $donationItem->expired_at;
                if (!$expiredAt && $donationItem->category === 'pangan_segar' && $donationItem->best_before_days) {
                    $expiredAt = now()->addDays((int) $donationItem->best_before_days)->toDateString();
                }

                // 4A) master gudang
                $warehouseItem = WarehouseItem::firstOrCreate(
                    [
                        'name' => $itemName,
                        'category' => $donationItem->category,
                    ],
                    [
                        'default_unit' => $unit,
                        'has_expired_date' => $donationItem->category === 'pangan_kemasan',
                    ]
                );

                // 4B) stok batch (unik: cabang+item+expired)
                $stock = WarehouseStock::firstOrCreate(
                    [
                        'cabang_id' => $cabangId,
                        'warehouse_item_id' => $warehouseItem->id,
                        'expired_at' => $expiredAt,
                    ],
                    [
                        'qty' => 0,
                        'unit' => $unit,
                        'batch_code' => null,
                    ]
                );

                // jaga unit konsisten
                if (strtolower($stock->unit) !== $unit) {
                    throw new \Exception("Unit stok tidak konsisten untuk item '{$warehouseItem->name}'. Stok: {$stock->unit}, input: {$unit}");
                }

                $stock->increment('qty', $donationItem->qty);

                // 4C) movement log
                WarehouseMovement::create([
                    'cabang_id' => $cabangId,
                    'warehouse_item_id' => $warehouseItem->id,
                    'type' => 'in',
                    'source_type' => 'donation',
                    'source_id' => $donation->id,
                    'expired_at' => $expiredAt,
                    'qty' => $donationItem->qty,
                    'unit' => $unit,
                    'created_by' => auth()->id(),
                    'note' => "Masuk dari donation_id={$donation->id}",
                    'moved_at' => now(),
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
        if ($donation->status === 'accepted') {
            return back()->with('error', 'Donasi accepted tidak boleh dihapus. Gunakan fitur Batalkan/Cancel.');
        }

        if ($donation->evidence_path) {
            Storage::disk('public')->delete($donation->evidence_path);
        }

        $donation->delete(); // items ikut kehapus karena FK cascade
        return back()->with('success', 'Data donasi berhasil dihapus.');
    }


    public function cancel(Request $request, Donation $donation)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($donation->status !== 'accepted') {
            return back()->with('error', 'Hanya donasi yang sudah diterima (accepted) yang bisa dibatalkan.');
        }

        DB::transaction(function () use ($donation, $request) {

            // ambil semua movement IN yang berasal dari donation ini
            $ins = WarehouseMovement::where('source_type', 'donation')
                ->where('source_id', $donation->id)
                ->where('type', 'in')
                ->lockForUpdate()
                ->get();

            foreach ($ins as $in) {
                // kurangi stok batch yang sesuai
                $stock = WarehouseStock::where('cabang_id', $in->cabang_id)
                    ->where('warehouse_item_id', $in->warehouse_item_id)
                    ->where('expired_at', $in->expired_at)
                    ->lockForUpdate()
                    ->first();

                if ($stock) {
                    $newQty = (float) $stock->qty - (float) $in->qty;
                    if ($newQty < 0) $newQty = 0;
                    $stock->update(['qty' => $newQty]);
                }

                // buat movement OUT sebagai rollback
                WarehouseMovement::create([
                    'cabang_id' => $in->cabang_id,
                    'warehouse_item_id' => $in->warehouse_item_id,
                    'type' => 'out',
                    'source_type' => 'donation_cancel',
                    'source_id' => $donation->id,
                    'expired_at' => $in->expired_at,
                    'qty' => $in->qty,
                    'unit' => $in->unit,
                    'created_by' => auth()->id(),
                    'note' => 'Rollback donasi: ' . $request->reason,
                    'moved_at' => now(),
                ]);
            }

            // update status donasi jadi rejected + catatan
            $donation->update([
                'status' => 'rejected',
                'note' => trim(($donation->note ? $donation->note . "\n" : '') . 'CANCEL: ' . $request->reason),
            ]);
        });

        return back()->with('success', 'Donasi dibatalkan dan stok gudang sudah dikembalikan.');
    }

    public function itemSuggest(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $category = $request->get('category'); // optional

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        // Ambil dari master gudang (warehouse_items) — ini yang paling “rapi”
        $items = WarehouseItem::query()
            ->select('name', 'category')
            ->when($category, fn($qr) => $qr->where('category', $category))
            ->where('name', 'like', $q . '%') // prefix search "be%"
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(fn($it) => [
                'label' => $it->name,
                'value' => $it->name,
                'category' => $it->category,
            ]);

        return response()->json($items);
    }


}
