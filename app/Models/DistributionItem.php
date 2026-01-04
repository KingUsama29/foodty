<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributionItem extends Model
{
    protected $table = 'distribution_items';

    protected $fillable = [
        'distribution_id',
        'warehouse_item_id',
        'expired_at',
        'qty',
        'unit',
        'note',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'expired_at' => 'date',
    ];

    public function distribution()
    {
        return $this->belongsTo(Distribution::class, 'distribution_id');
    }

    public function warehouseItem()
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id');
    }
}
