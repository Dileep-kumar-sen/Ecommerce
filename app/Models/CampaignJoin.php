<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignJoin extends Model
{
    use HasFactory;

    protected $table = 'campaign_join';

    protected $fillable = [
        'business_id',
        'campaign_id',
        'count_offer'
    ];
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
