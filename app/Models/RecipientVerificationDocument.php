<?php

namespace App\Models;
use App\Models\RecipientVerification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipientVerificationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_verification_id',
        'type',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function verification(){
        return $this->belongsTo(RecipientVerification::class, 'recipient_verification_id');
    }
}
