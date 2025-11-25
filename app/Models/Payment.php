<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_type',
        'amount',
        'currency',
        'payment_method',
        'payment_id',
        'status',
        'expire_date',
        'membership_status',
    ];
    public function plan()
{
    // 🔹 plan_id se membership_plans table ke id ko link karo
    return $this->belongsTo(Membership_plan::class, 'plan_id', 'id');
    // Offer model ke andar plan_tier column hoga
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
