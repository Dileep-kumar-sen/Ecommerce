<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
     protected $fillable = [
        'user_id',
        'offer_id',
        'description',
    ];
       // Report belongs to user
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Report belongs to offer
    public function offer() {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
