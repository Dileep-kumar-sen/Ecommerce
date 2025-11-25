<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
   protected $table='create_offers';
    protected $fillable = [
        'business_id',
        'title',
        'description',
        'expiry_datetime',
        'stock_limit',
        'category_id',
        'subcategory_id',
        'price',
        'discount',
        'discount_price',
        'voucher_code',
        'image',
        'status'
    ];

    public function category() {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function subcategory() {
        return $this->belongsTo(\App\Models\Subcategory::class);
    }

    public function business() {
        return $this->belongsTo(\App\Models\Business::class);
    }
}
