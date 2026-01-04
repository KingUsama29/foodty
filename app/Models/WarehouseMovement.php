<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseMovement extends Model
{
    protected $table = 'warehouse_movements';

    protected $fillable = [
        'cabang_id','warehouse_item_id','type','source_type','source_id',
        'expired_at','qty','unit','created_by','note','moved_at'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'expired_at' => 'date',
        'moved_at' => 'datetime',
    ];
}
