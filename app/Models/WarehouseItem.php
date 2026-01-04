<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    protected $table = 'warehouse_items';

    protected $fillable = ['name','category','default_unit','has_expired_date'];

    protected $casts = ['has_expired_date' => 'boolean'];
}
