<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyaluranController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = \App\Models\Cabang::orderBy('name')->get();

        $q = trim($request->get('q', ''));
        $cabangId = $request->get('cabang_id');

        // Audit penyaluran: ambil dari warehouse_movements type=out
        // Link penerima lewat distributions (source_type = 'distribution')
        $audit = DB::table('warehouse_movements as wm')
            ->join('cabangs as c', 'c.id', '=', 'wm.cabang_id')
            ->join('warehouse_items as wi', 'wi.id', '=', 'wm.warehouse_item_id')
            ->join('users as petugas', 'petugas.id', '=', 'wm.created_by')

            // ini kuncinya: join ke distributions dari source_id
            ->leftJoin('distributions as d', function ($j) {
                $j->on('d.id', '=', 'wm.source_id')
                  ->where('wm.source_type', '=', 'distribution');
            })

            // optional: kalau mau tetap punya akses ke pengajuan
            ->leftJoin('food_requests as fr', 'fr.id', '=', 'd.food_request_id')
            ->leftJoin('users as pemohon', 'pemohon.id', '=', 'fr.user_id')

            ->select(
                'wm.id',
                'wm.moved_at',
                'wm.note',
                'wm.expired_at',
                'wm.qty',
                'wm.unit',

                'c.id as cabang_id',
                'c.name as nama_cabang',

                'petugas.name as nama_petugas',

                'wi.name as nama_barang',
                'wi.category as kategori',

                // penerima paling aman ambil dari distributions.recipient_name
                DB::raw("COALESCE(NULLIF(d.recipient_name,''), pemohon.name, '-') as nama_penerima"),

                // optional info audit tambahan
                'd.id as distribution_id',
                'd.food_request_id',
                'd.status as status_penyaluran',
                'd.scheduled_at',
                'd.distributed_at'
            )
            ->where('wm.type', 'out')
            ->when($cabangId, fn($s) => $s->where('wm.cabang_id', $cabangId))
            ->when($q, function ($s) use ($q) {
                $s->where(function ($w) use ($q) {
                    $w->where('c.name', 'like', "%{$q}%")
                      ->orWhere('petugas.name', 'like', "%{$q}%")
                      ->orWhere('wi.name', 'like', "%{$q}%")
                      ->orWhere('wi.category', 'like', "%{$q}%")
                      ->orWhere('wm.note', 'like', "%{$q}%")
                      ->orWhere('d.recipient_name', 'like', "%{$q}%")
                      ->orWhere('pemohon.name', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('wm.moved_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.penyaluran', compact('cabangs', 'audit', 'q', 'cabangId'));
    }

    public function show($id)
    {
        $row = DB::table('warehouse_movements as wm')
            ->join('cabangs as c', 'c.id', '=', 'wm.cabang_id')
            ->join('warehouse_items as wi', 'wi.id', '=', 'wm.warehouse_item_id')
            ->join('users as petugas', 'petugas.id', '=', 'wm.created_by')
            ->leftJoin('distributions as d', function ($j) {
                $j->on('d.id', '=', 'wm.source_id')
                  ->where('wm.source_type', '=', 'distribution');
            })
            ->leftJoin('food_requests as fr', 'fr.id', '=', 'd.food_request_id')
            ->leftJoin('users as pemohon', 'pemohon.id', '=', 'fr.user_id')
            ->select(
                'wm.*',
                'c.name as nama_cabang',
                'petugas.name as nama_petugas',
                'wi.name as nama_barang',
                'wi.category as kategori',
                DB::raw("COALESCE(NULLIF(d.recipient_name,''), pemohon.name, '-') as nama_penerima"),

                // detail audit tambahan
                'd.id as distribution_id',
                'd.food_request_id',
                'd.status as status_penyaluran',
                'd.note as note_penyaluran',
                'd.scheduled_at',
                'd.distributed_at'
            )
            ->where('wm.id', $id)
            ->where('wm.type', 'out')
            ->first();

        abort_if(!$row, 404);

        return view('admin.penyaluran-detail', compact('row'));
    }
}
