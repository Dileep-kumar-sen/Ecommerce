<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRedeem extends Model
{
    use HasFactory;

    protected $table = 'user_redeem';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'vchcode',
        'offer_id',
        'campaign_id',
        'status',
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Offer relationship
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
