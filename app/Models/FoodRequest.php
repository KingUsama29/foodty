<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FoodRequest extends Model
{
    protected $casts = [
        'reviewed_at'=>'datetime',
    ];
    protected $fillable = [
        'user_id',
        'request_for',
        'recipient_name',
        'recipient_phone',
        'relationship',
        'category',
        'dependents',
        'address_detail',
        'reason',
        'main_needs',
        'description',
        'file_path',
        'status',
        'reviewed_by',
        'review_notes',
        'reviewed_at',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }   
}
