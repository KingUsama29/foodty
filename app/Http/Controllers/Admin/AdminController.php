<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // =========================
        // KPI Pengajuan
        // =========================
        $totalPending  = DB::table('food_requests')->where('status', 'pending')->count();
        $totalApproved = DB::table('food_requests')->where('status', 'approved')->count();
        $totalRejected = DB::table('food_requests')->where('status', 'rejected')->count();

        // Doughnut: status pengajuan
        $foodReqStatus = DB::table('food_requests')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // =========================
        // Line: penyaluran 7 hari terakhir
        // =========================
        $days = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i));
        $labels7 = $days->map(fn ($d) => $d->format('d M'))->values();

        $rows = DB::table('distributions')
            ->whereDate('created_at', '>=', Carbon::today()->subDays(6))
            ->selectRaw('DATE(created_at) as d, status, COUNT(*) as total')
            ->groupBy('d', 'status')
            ->get();

        $map = $rows->groupBy('status')->map(fn ($items) => $items->keyBy('d'));

        $completed7 = $days->map(fn ($d) => (int) data_get($map, 'completed.' . $d->toDateString() . '.total', 0))->values();
        $scheduled7 = $days->map(fn ($d) => (int) data_get($map, 'scheduled.' . $d->toDateString() . '.total', 0))->values();
        $canceled7  = $days->map(fn ($d) => (int) data_get($map, 'canceled.'  . $d->toDateString() . '.total', 0))->values();

        $totalDistributions = DB::table('distributions')->count();

        // =========================
        // Bar: Hampir expired per cabang
        // =========================
        $cutoff = Carbon::today()->addMonths(6)->endOfDay();

        /**
         * IMPORTANT:
         * Banyak UI stok menandai "hampir expired" walau qty = 0 (contoh gula lu).
         * Kalau lu MAU ngikutin UI lu, JANGAN filter qty > 0.
         *
         * Kalau lu maunya hanya yg ada stok, aktifin filter qty > 0.
         */
        $followUiIncludeQtyZero = true; // <-- set false kalau mau qty harus > 0

        // Subquery: per cabang_id + warehouse_item_id, cari expired terdekat (MIN(expired_at))
        // lalu filter yg <= cutoff
        $sub = DB::table('warehouse_stocks as ws')
            ->selectRaw('ws.cabang_id, ws.warehouse_item_id, MIN(ws.expired_at) as nearest_expired, SUM(ws.qty) as total_qty')
            ->whereNotNull('ws.expired_at')
            ->groupBy('ws.cabang_id', 'ws.warehouse_item_id');

        if (!$followUiIncludeQtyZero) {
            $sub->havingRaw('SUM(ws.qty) > 0');
        }

        // wrap subquery biar bisa where nearest_expired <= cutoff
        $expiringPerBranch = DB::query()
            ->fromSub($sub, 'x')
            ->join('cabangs as c', 'c.id', '=', 'x.cabang_id')
            ->whereDate('x.nearest_expired', '<=', $cutoff->toDateString())
            ->selectRaw('c.name as cabang, COUNT(*) as items')
            ->groupBy('c.name')
            ->orderByDesc('items')
            ->get();

        $expBranchLabels = $expiringPerBranch->pluck('cabang')->values();
        $expBranchValues = $expiringPerBranch->pluck('items')->map(fn ($v) => (int) $v)->values();

        // KPI total item hampir expired (sum semua cabang)
        $totalExpiringItems = (int) $expiringPerBranch->sum('items');

        return view('dashboard.admin', compact(
            'totalPending',
            'totalApproved',
            'totalRejected',
            'totalDistributions',
            'totalExpiringItems',
            'foodReqStatus',
            'labels7',
            'completed7',
            'scheduled7',
            'canceled7',
            'expBranchLabels',
            'expBranchValues'
        ));
    }
}
