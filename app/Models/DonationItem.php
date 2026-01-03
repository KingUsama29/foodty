<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    protected $fillable = [
        'donation_id', 'item_name', 'category', 'qty', 'unit',
        'condition', 'expired_at', 'best_before_days', 'note'
    ];

    protected $casts = [
        'expired_at' => 'date',
        'qty' => 'decimal:2',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
