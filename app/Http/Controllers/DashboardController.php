<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request){
        $role = $request->user()->role;

        if($role === "penerima"){
            return redirect()->route('penerima.dashboard');
        }elseif($role === "petugas"){
            return redirect()->route('petugas.dashboard');
        }elseif($role === "admin"){
            return redirect()->route('admin.dashboard');
        }else{
            abort(403);
        }

    }
}
