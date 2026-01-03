<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load([
            'recipientVerification.documents', // pastikan relasinya ada (lihat model section di bawah)
        ]);

        return view('penerima.profile', compact('user'));
    }
}
