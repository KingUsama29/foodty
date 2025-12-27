<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PetugasProfile;

class Cabang extends Model
{
    protected $fillable = [
        'name',
        'alamat',
        'is_active',
    ];

    public function petugasProfiles()
    {
        return $this->hasMany(PetugasProfile::class);
    }
}
