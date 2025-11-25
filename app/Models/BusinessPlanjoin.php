<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPlanjoin extends Model
{
    protected $table='business_plan_join';
    protected $fillable = [
        'business_id',
        'plan',
        'payment_id	',
    ];
}
