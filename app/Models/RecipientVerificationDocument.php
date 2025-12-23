<?php

namespace App\Models;
use App\Models\RecipientVerification;
use Illuminate\Database\Eloquent\Model;

class RecipientVerificationDocument extends Model
{

    public function Verification(){
        return $this->belongsTo(RecipientVerification::class, 'recipient_verification_id');
    }
}
