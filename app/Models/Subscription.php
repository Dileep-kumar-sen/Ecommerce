<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'mp_subscription_id',
        'current_period_start',
        'current_period_end',
    ];
}
