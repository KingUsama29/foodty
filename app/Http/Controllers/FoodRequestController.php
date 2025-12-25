<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FoodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category'      => 'required|string',
            'description'   => 'nullable|string',
            'file_path'     => 'required|file|mimes:jpeg,jpg,png|max:2048',
        ]);
        DB::beginTransaction();

        try{
            $path = $request->file('file_path')->store(
                'food_requests/' . $request->user()->id,
                'public'
            );

            FoodRequest::create([
                'user_id'       =>  $request->user()->id,
                'category'      => $validate['category'],
                'description'   => $validate['description'] ?? null,
                'file_path'     => $path,
                'status'        => 'pending',
            ]);

            DB::commit();
            return redirect('/dashboard')->with('success','Permintaan Berhasil Diajukan, Tunggu Persetujuan Dari Admin!');
        }catch(\Throwable $e){
            DB::rollBack();
            Log::error('Food Request store failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('failed', 'Terjadi Kesalahan Saat Menyimpan Data Pengajuan. Coba Lagi Ya.');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
