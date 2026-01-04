<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStock extends Model
{
    protected $table = 'warehouse_stocks';

    protected $fillable = [
        'cabang_id','warehouse_item_id','expired_at','batch_code','qty','unit'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'expired_at' => 'date',
    ];
}
