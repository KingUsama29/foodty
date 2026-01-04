<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'food_request_id',
        'cabang_id',
        'distributed_by',
        'distributed_at',
        'scheduled_at',
        'status',
        'note',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
    ];

    protected $casts = [
        'distributed_at' => 'datetime',
        'scheduled_at' => 'datetime',
    ];

    public function request()
    {
        return $this->belongsTo(FoodRequest::class, 'food_request_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    public function items()
    {
        return $this->hasMany(DistributionItem::class, 'distribution_id');
    }
}
