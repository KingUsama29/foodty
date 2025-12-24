<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipientVerification;
use Illuminate\Support\Facades\Log;

class RecipientVerificationController extends Controller
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
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $check = RecipientVerification::where('user_id', $request->user()->id)->latest('id')->first();
    
        if($check && in_array($check->verification_status, ['pending', 'approved'], true)){
            $message = $check->verification_status === 'pending' ? 'Verifikasi kamu masih diproses admin. Tunggu dulu ya.' : 'Akun kamu sudah terverifikasi. Tidak perlu verifikasi ulang.';
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $message], 422);
            }

            return redirect('/dashboard')->with('failed', $message);
        }

        $validated = $request->validate([
            'ktp'           => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'selfie_ktp'    => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'kk'            => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'full_name'     => 'required|string|max:255',
            'kk_number'     => 'required|digits:16',
            'alamat'        => 'required|string',
            'province'      => 'required|string|max:50',
            'city'          => 'required|string|max:50',
            'district'      => 'required|string|max:50',
            'postal_code'   => 'required|digits:5',
        ]);

        try{
            $verification = RecipientVerification::create([
                'user_id'       => $request->user()->id,
                'full_name'     =>  $validated['full_name'],
                'kk_number'     =>  $validated['kk_number'],
                'alamat'        =>  $validated['alamat'],
                'province'      =>  $validated['province'],
                'city'          =>  $validated['city'],
                'district'      =>  $validated['district'],
                'postal_code'   =>  $validated['postal_code'],
            ]);

            $files = [
                'ktp'        => $request->file('ktp'),
                'selfie_ktp' => $request->file('selfie_ktp'),
                'kk'         => $request->file('kk'),
            ];

            foreach($files as $type => $file){
                $path = $file->store("verifications/{$verification->id}", "public");

                $verification->documents()->create([
                    'type'          => $type,
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getMimeType(),
                    'file_size'     => $file->getSize(),
                ]);
            }

            if($request->expectsJson() || $request->is('api/*')){
                return response()->json(['message' => 'Verifikasi Akun Telah Dikirim,  menunggu persetujuan admin.', 'verification' => $verification], 201);
            }
            return redirect('/dashboard')->with('success','Data Verifikasi Berhasil Dikirim, Silahkan Menunggu Persetujuan Admin!');
        }catch (\Throwable $e) {
            // Log untuk debugging
            Log::error('Recipient verification store failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
            ]);

            $failMsg = 'Terjadi kesalahan saat menyimpan data verifikasi. Coba lagi ya.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => $failMsg], 500);
            }

            // withInput() biar form gak kosong lagi
            return back()->withInput()->with('failed', $failMsg);
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
