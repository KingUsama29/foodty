<?php

namespace App\Models;
use App\Models\RecipientVerificationDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipientVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nik',
        'full_name',
        'kk_number',
        'alamat',
        'province',
        'city',
        'district',
        'postal_code',
        'verification_status',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documents(){
        return $this->hasMany(RecipientVerificationDocument::class);
    }
}
