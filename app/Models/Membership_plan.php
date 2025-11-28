<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership_plan extends Model
{
     use HasFactory;

    protected $table = 'membership_plans';
    protected $fillable = [
        'plan_tier',
        'trial_period_days',
        'coupons_per_week',
        'discount_limit',
        'exclusive_offers_monthly',
        'features',
        'achievements',
        'referral_bonus',
        'plan_price',
        'description',
        'plan_icon',
        'month_year',
        'color',
    ];
    public function payments()
{
    return $this->hasMany(Payment::class, 'plan_id');
}

}
