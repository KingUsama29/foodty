<?php

namespace App\Models;
use App\Models\RecipientVerificationDocument;
use Illuminate\Database\Eloquent\Model;

class RecipientVerification extends Model
{

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documents(){
        return $this->hasMany(RecipientVerificationDocument::class);
    }
}
