<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_id', 'cabang_id', 'received_by',
        'donated_at', 'status', 'note', 'evidence_path'
    ];

    protected $casts = [
        'donated_at' => 'datetime',
    ];

    public function receivedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'received_by');
    }

   public function cabang()
    {
        return $this->belongsTo(\App\Models\Cabang::class, 'cabang_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }

    public function items()
    {
        return $this->hasMany(DonationItem::class, 'donation_id');
    }
}
