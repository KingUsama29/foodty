<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function index()
    {
        $pendingFoodRequest = DB::table('food_requests')->where('status', 'pending')->count();
        $approvedFoodRequest = DB::table('food_requests')->where('status', 'approved')->count();
        $completedDistributions = DB::table('distributions')->where('status', 'completed')->count();

        $foodReqStatus = DB::table('food_requests')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $donationStatus = DB::table('donations')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $from = Carbon::now()->subDays(6)->startOfDay();
        $to = Carbon::now()->endOfDay();

        $distDaily = DB::table('distributions')
            ->select(
                DB::raw("DATE(created_at) as d"),
                DB::raw("SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) as canceled"),
                DB::raw("SUM(CASE WHEN status='scheduled' THEN 1 ELSE 0 END) as scheduled")
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy('d')
            ->get();

        $labels7 = [];
        $completed7 = [];
        $canceled7 = [];
        $scheduled7 = [];

        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
            $labels7[] = Carbon::parse($day)->format('d M');

            $row = $distDaily->firstWhere('d', $day);
            $completed7[] = (int) ($row->completed ?? 0);
            $canceled7[] = (int) ($row->canceled ?? 0);
            $scheduled7[] = (int) ($row->scheduled ?? 0);
        }

        // approved dan belum ada scheduled/completed
        $readyRequests = DB::table('food_requests as fr')
            ->leftJoin('distributions as d', function ($join) {
                $join->on('d.food_request_id', '=', 'fr.id')
                    ->whereIn('d.status', ['scheduled', 'completed']);
            })
            ->join('users as u', 'u.id', '=', 'fr.user_id')
            ->where('fr.status', 'approved')
            ->whereNull('d.id')
            ->select('fr.*', 'u.name as user_name')
            ->orderBy('fr.created_at', 'asc')
            ->limit(8)
            ->get();

        // PENTING: sesuaikan dengan lokasi file blade lu
        // kalau file lu resources/views/dashboard/petugas.blade.php
        return view('dashboard.petugas', compact(
            'pendingFoodRequest',
            'approvedFoodRequest',
            'completedDistributions',
            'foodReqStatus',
            'donationStatus',
            'labels7',
            'completed7',
            'canceled7',
            'scheduled7',
            'readyRequests'
        ));
    }
}