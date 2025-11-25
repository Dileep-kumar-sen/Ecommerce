<?php
// app/Models/Business.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Business extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'name',
        'email',
        'password',
        'latitude',
        'phone',
        'longitude',
        'location',
        'profile',
    ];

    protected $hidden = [
        'password',
    ];
}
