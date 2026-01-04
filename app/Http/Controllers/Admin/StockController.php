<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stok = DB::table('warehouse_stocks')
            ->join('cabangs', 'cabangs.id', '=', 'warehouse_stocks.cabang_id')
            ->join('warehouse_items', 'warehouse_items.id', '=', 'warehouse_stocks.warehouse_item_id')
            ->select(
                'cabangs.id as cabang_id',
                'cabangs.name as nama_cabang',

                // ✅ penting: bawa ID item buat route detail
                'warehouse_items.id as warehouse_item_id',
                'warehouse_items.name as nama_barang',
                'warehouse_items.category as kategori',

                'warehouse_stocks.unit',
                DB::raw('SUM(warehouse_stocks.qty) as total_qty'),
                DB::raw('MIN(warehouse_stocks.expired_at) as expired_terdekat')
            )
            ->groupBy(
                'cabangs.id',
                'cabangs.name',

                // ✅ karena dipilih, wajib masuk groupBy
                'warehouse_items.id',
                'warehouse_items.name',
                'warehouse_items.category',

                'warehouse_stocks.unit'
            )
            ->orderBy('cabangs.name')
            ->orderBy('warehouse_items.category')
            ->orderBy('warehouse_items.name')
            ->get()
            ->groupBy('cabang_id');

        return view('admin.stok-barang', compact('stok'));
    }

    public function show($cabangId, $warehouseItemId, Request $request)
    {
        $cabang = DB::table('cabangs')->where('id', $cabangId)->first();
        abort_if(!$cabang, 404);

        $item = DB::table('warehouse_items')->where('id', $warehouseItemId)->first();
        abort_if(!$item, 404);

        // ✅ stok per batch (expired_at)
        $batches = DB::table('warehouse_stocks')
            ->where('cabang_id', $cabangId)
            ->where('warehouse_item_id', $warehouseItemId)
            ->orderByRaw('expired_at is null') // null terakhir
            ->orderBy('expired_at')
            ->orderBy('id')
            ->get();

        $totalQty = (float) $batches->sum('qty');
        $unit = $batches->first()->unit ?? ($item->default_unit ?? 'pcs');
        $expiredTerdekat = $batches->whereNotNull('expired_at')->min('expired_at');

        // ✅ riwayat movement (buat audit + rollback)
        $movements = DB::table('warehouse_movements as wm')
            ->join('users as u', 'u.id', '=', 'wm.created_by')
            ->select(
                'wm.id',
                'wm.type',
                'wm.source_type',
                'wm.source_id',
                'wm.expired_at',
                'wm.qty',
                'wm.unit',
                'wm.note',
                'wm.moved_at',
                'u.name as created_by_name'
            )
            ->where('wm.cabang_id', $cabangId)
            ->where('wm.warehouse_item_id', $warehouseItemId)
            ->orderByDesc('wm.moved_at')
            ->orderByDesc('wm.id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.stok-barang-detail', compact(
            'cabang',
            'item',
            'batches',
            'totalQty',
            'unit',
            'expiredTerdekat',
            'movements'
        ));
    }
}
