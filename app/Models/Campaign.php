<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'campaign_name',
        'start_date',
        'end_date',
        'categories',
        'subcategories',
        'join_fee',
        'discount_rules',
        'benefit',
        'max_offer',
        'banner',
        'description',
    ];

}
