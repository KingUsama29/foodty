<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PetugasProfile extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'no_telp',
        'alamat',
        'cabang_id',
        'is_active',
    ];
    

    public function user(){
        return $this->belongsTo(User::class);
    }
}
