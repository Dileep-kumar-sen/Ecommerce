<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMembershipPlan extends Model
{
    protected $table = 'business_membership_plan';

    protected $fillable = [
        'plan_tier',
        'trial_days',
        'discount',
        'active_offers',
        'plan_price',
        'duration_months',
        'visibility_level',
        'metrics_access',
        'highlight_banner',
        'push_notifications',
        'marketing_campaigns',
        'description',
        'status'
    ];
}
